<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;
use App\Models\SaleHistory;

class HomeController extends Controller
{
    
    public function index()
    {
        $category = Category::where(['status'=> 1, 'cat_id' => 0])->count();
        $categoryPercentage = $this->categoryPercentage();

        $supplier = Supplier::where(['status'=> 1])->count();
        $supplierPercentage = $this->supplierPercentage();

        $user = User::count();
        $userPercentage = $this->userPercentage();

        $customer = Customer::where(['status'=> 1])->count();
        $customerPercentage = $this->customerPercentage($customer);

        $currentMonth = Carbon::now()->month;
        $sale = Sale::sum('grand_total');
        $salePercentage = $this->salePercentage();

        $purchase = Purchase::sum('total');
        $purchasePercentage = $this->purchasePercentage();

        $product = Product::where(['status'=> 1])->count();
        $products = SaleHistory::select('product_id', \DB::raw('SUM(quantity) as total_sales'))
        ->with(['Product'=> function($query){
            $query->withTrashed();
        }])
        ->groupBy('product_id')
        ->orderByDesc('total_sales')
        ->take(5)
        ->get();

        $productPercentage = $this->productPercentage();
        $payment = Purchase::sum('amount');

        $salePaymentPercentage = $this->salePaymentPercentage();

        $saleData = Sale::whereYear('created_at', Carbon::now()->year)
                        ->orderBy('created_at')
                        ->pluck('grand_total')
                        ->toArray();

        // Fetch purchase data for each month
        $purchaseData = Purchase::whereYear('created_at', Carbon::now()->year)
                                ->orderBy('created_at')
                                ->pluck('total')
                                ->toArray();

        // Months
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $currentYear = Carbon::now()->year;
        $startOfLastYear = Carbon::now()->subYear()->startOfYear();
        $endOfLastYear = Carbon::now()->subYear()->endOfYear();

        $startOfCurrentYear = Carbon::now()->startOfYear();
        $endOfCurrentYear = Carbon::now()->endOfYear();

        // Fetch sales data count for the current year
        $currentYearSalesCount = Sale::whereBetween('created_at', [$startOfCurrentYear, $endOfCurrentYear])->sum('grand_total');

        // Fetch sales data count for the previous year
        $previousYearSalesCount = Sale::whereBetween('created_at', [$startOfLastYear, $endOfLastYear])->sum('grand_total');

        // Fetch purchase data sum for the current year
        $currentYearPurchasesSum = Purchase::whereBetween('created_at', [$startOfCurrentYear, $endOfCurrentYear])->sum('total');

        // Fetch purchase data sum for the previous year
        $previousYearPurchasesSum = Purchase::whereBetween('created_at', [$startOfLastYear, $endOfLastYear])->sum('total');

        // Calculate the percentage increase in sales count
        $salesIncreasePercentage = ($currentYearSalesCount - $previousYearSalesCount) / max(($previousYearSalesCount ?: 1), $currentYearSalesCount) * 100;

        // Calculate the percentage increase in purchases sum
        $purchasesIncreasePercentage = ($currentYearPurchasesSum - $previousYearPurchasesSum) / max(($previousYearPurchasesSum ?: 1), $currentYearPurchasesSum) * 100;

        // Format the percentages
        $saleYearly = round($salesIncreasePercentage, 2);
        $purchaseYearly = round($purchasesIncreasePercentage, 2);

        return view('admin.dashboard', compact('category', 'supplier', 'product', 'user', 'customer', 'sale', 'purchase', 'products', 'customerPercentage', 'supplierPercentage', 'userPercentage', 'productPercentage', 'salePercentage', 'purchasePercentage', 'categoryPercentage', 'salePaymentPercentage','saleData', 'purchaseData', 'months', 'saleYearly', 'purchaseYearly','payment'));
    }

    public function categoryPercentage(){
        // Get the date for yesterday
        $yesterday = Carbon::yesterday();

        // Count of categories for yesterday
        $categoriesYesterdayCount = Category::whereDate('created_at', $yesterday)->count();

        // Count of categories for today
        $categoriesTodayCount = Category::whereDate('created_at', Carbon::today())->count();

        // Calculate the percentage change
        if ($categoriesYesterdayCount > 0) {
            $categoryPercentage = (($categoriesTodayCount - $categoriesYesterdayCount) / $categoriesYesterdayCount) * 100;
        } else {
            // Handle division by zero
            $categoryPercentage = 0;
        }

        return round($categoryPercentage, 2);
    }

    public function supplierPercentage(){

        $startOfLastWeek = Carbon::now()->startOfWeek()->subWeek();
        $endOfLastWeek = Carbon::now()->startOfWeek()->subSecond();

        // Get the count of suppliers since last week
        $countSinceLastWeek = Supplier::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->count();

        // Get the total count of suppliers
        $totalSuppliers = Supplier::count();

        // Calculate the percentage change
        $supplierPercentage = $totalSuppliers > 0 ? ($countSinceLastWeek / $totalSuppliers) * 100 : 0;
        return round($supplierPercentage, 2);
    }

    public function userPercentage(){
        // Get the start and end of the current month
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        // Get the start and end of the previous month
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Count of users for the current month
        $currentMonthUserCount = User::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();

        // Count of users for the previous month
        $previousMonthUserCount = User::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        if ($previousMonthUserCount != 0) {
            // Calculate the percentage change
            $userPercentage = (($currentMonthUserCount - $previousMonthUserCount) / $previousMonthUserCount) * 100;
            if($userPercentage >= 100){
                $userPercentage = 100;
            }elseif($userPercentage <= 0){
                $userPercentage = 0;
            }
        } else {
            // Handle division by zero
            if ($currentMonthUserCount != 0) {
                // If the previous month's user count is zero but the current month's user count is not,
                // you might want to set the percentage to a default value, such as 100% or any other suitable value.
                $userPercentage = 100; // or any other value that suits your logic
            } else {
                // If both previous and current month's user counts are zero,
                // you might want to set the percentage to a default value, such as 0% or any other suitable value.
                $userPercentage = 0; // or any other default value
            }
        }

        return round($userPercentage, 2);
    }

    public function customerPercentage($customer){
        $currentCustomerCount = Customer::where('status', 1)
            ->whereDate('created_at',  Carbon::today())
            ->count();

        // Get the count of active customers from yesterday
        $previousCustomerCount = Customer::where('status', 1)
            ->whereDate('created_at', Carbon::yesterday())
            ->count();

        // Calculate the percentage change
        if ($previousCustomerCount != 0) {
            $customerPercentage = abs(($currentCustomerCount - $previousCustomerCount) / $previousCustomerCount) * 100;
        } else {
            // Handle division by zero
            $customerPercentage = 0;
        }
        
        return round($customerPercentage, 2);
    }

    public function salePercentage(){
        $currentDate = Carbon::now();

        // Determine the quarters for the current and previous quarters
        $currentQuarter = ceil($currentDate->quarter);
        $currentYear = $currentDate->year;
        $previousQuarter = $currentQuarter - 1;
        $previousYear = $currentYear;

        // Adjust the previous quarter and year if it's the first quarter of the year
        if ($previousQuarter == 0) {
            $previousQuarter = 4;
            $previousYear = $currentYear - 1;
        }

        // Calculate the start and end dates for the current quarter
        $currentQuarterStart = Carbon::createFromDate($currentYear, ($currentQuarter - 1) * 3 + 1, 1)->startOfMonth();
        $currentQuarterEnd = Carbon::createFromDate($currentYear, $currentQuarter * 3, 1)->endOfMonth();

        // Calculate the start and end dates for the previous quarter
        $previousQuarterStart = Carbon::createFromDate($previousYear, ($previousQuarter - 1) * 3 + 1, 1)->startOfMonth();
        $previousQuarterEnd = Carbon::createFromDate($previousYear, $previousQuarter * 3, 1)->endOfMonth();

        // Get the sales for the current quarter
        $currentQuarterSales = Sale::whereBetween('created_at', [$currentQuarterStart, $currentQuarterEnd])->sum('grand_total');

        // Get the sales for the previous quarter
        $previousQuarterSales = Sale::whereBetween('created_at', [$previousQuarterStart, $previousQuarterEnd])->sum('grand_total');

        // Calculate the percentage change
        if ($previousQuarterSales != 0) {
            $salePercentage = ($currentQuarterSales - $previousQuarterSales) / $previousQuarterSales * 100;
            if($salePercentage >= 100){
                $salePercentage = 100;
            }elseif($salePercentage <= 0){
                $salePercentage = 0;
            }
        } else {
            $salePercentage = ($currentQuarterSales != 0) ? 100 : 0; // Avoid division by zero
        }

        return round($salePercentage, 2);
    }

    public function purchasePercentage(){
        $startOfMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfMonth = Carbon::now()->subMonth()->endOfMonth();

        // Retrieve the total purchase amount for last month
        $totalPurchaseLastMonth = Purchase::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total');
        $currentMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalPurchaseCurrentMonth = Purchase::whereBetween('created_at', [$currentMonth, $endOfMonth])->sum('total'); 
        // Avoid division by zero error
        if ($totalPurchaseLastMonth != 0) {
            // Calculate the percentage
            $purchasePercentage = (($totalPurchaseCurrentMonth - $totalPurchaseLastMonth) / $totalPurchaseLastMonth) * 100;
            if($purchasePercentage >= 100){
                $purchasePercentage = 100;
            }
        } else {
            if ($totalPurchaseCurrentMonth != 0) {
                // Handle the case where last month's purchase is zero but current month's purchase is not
                $purchasePercentage = 100; // or any other value that suits your logic
            } else {
                // Handle the case where both last month's and current month's purchases are zero
                $purchasePercentage = 0; // or any other default value
            }
        }
        return round($purchasePercentage, 2);
    }

    public function salePaymentPercentage(){
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();
        $previousWeekStart = Carbon::now()->endOfWeek()->subWeek();
        $previousWeekEnd = Carbon::now()->endOfWeek()->subWeek();
        $currentWeekTotalPayment = Purchase::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->sum('total');

        // Total payment amount for the previous week
        $previousWeekTotalPayment = Purchase::whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])->sum('total');

        // Calculate the percentage change
        if ($previousWeekTotalPayment != 0) {
            // Calculate the percentage change
            $salePaymentPercentage = (($currentWeekTotalPayment - $previousWeekTotalPayment) / $previousWeekTotalPayment) * 100;
            if($salePaymentPercentage >= 100){
                $salePaymentPercentage = 100;
            }elseif($salePaymentPercentage <= 0){
                $salePaymentPercentage = 0;
            }
        } else {
            // Handle division by zero
            if ($currentWeekTotalPayment != 0) {
                $salePaymentPercentage = 100; // or any other value that suits your logic
            } else {
                $salePaymentPercentage = 0; // or any other default value
            }
        }

        return round($salePaymentPercentage, 2);
    }

    public function productPercentage(){
        $startOfLastQuarter = Carbon::now()->startOfQuarter()->subQuarter();
        $endOfLastQuarter = Carbon::now()->startOfQuarter()->subSecond();

        // Get the count of products with status 1 since the last quarter
        $countSinceLastQuarter = Product::where('status', 1)
            ->whereBetween('created_at', [$startOfLastQuarter, $endOfLastQuarter])
            ->count();

        // Calculate the percentage
        $totalProducts = Product::where('status', 1)->count();
        $productPercentage = $totalProducts > 0 ? ($countSinceLastQuarter / $totalProducts) * 100 : 0;

        return round($productPercentage, 2);
    }
}
