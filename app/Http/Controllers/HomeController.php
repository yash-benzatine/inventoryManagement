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

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    //  private $categoryPercentage;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     // Assign the value returned by categoryPercentage method to categoryPercentage property
    //     $this->categoryPercentage = $this->categoryPercentage();
    // }


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
        $sale = Sale::where('created_at', '>=', $currentMonth)->count();
        $salePercentage = $this->salePercentage();

        $purchase = Purchase::where('created_at', '>=', $currentMonth)->count();
        $purchasePercentage = $this->purchasePercentage();

        $product = Product::where(['status'=> 1])->count();
        $products = Product::where('status', 1)->latest()->limit(5)->get();
        $productPercentage = $this->productPercentage();
        $payment = Sale::sum('received_amount');

        $salePaymentPercentage = $this->salePaymentPercentage();

        $saleData = Sale::whereYear('created_at', Carbon::now()->year)
                        ->orderBy('created_at')
                        ->pluck('received_amount')
                        ->toArray();

        // Fetch purchase data for each month
        $purchaseData = Purchase::whereYear('created_at', Carbon::now()->year)
                                ->orderBy('created_at')
                                ->pluck('amount')
                                ->toArray();

        // Months
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $currentYear = Carbon::now()->year;
        $previousYear = $currentYear - 1;

        // Fetch sales data count for the current year
        $currentYearSalesCount = Sale::whereYear('created_at', $currentYear)->count();

        // Fetch sales data count for the previous year
        $previousYearSalesCount = Sale::whereYear('created_at', $previousYear)->count();

        // Fetch purchase data sum for the current year
        $currentYearPurchasesSum = Purchase::whereYear('created_at', $currentYear)->count();

        // Fetch purchase data sum for the previous year
        $previousYearPurchasesSum = Purchase::whereYear('created_at', $previousYear)->count();

        // Calculate the percentage increase in sales count
        $salesIncreasePercentage = ($currentYearSalesCount - $previousYearSalesCount) / ($previousYearSalesCount ?: 1) * 100;

        // Calculate the percentage increase in purchases sum
        $purchasesIncreasePercentage = ($currentYearPurchasesSum - $previousYearPurchasesSum) / ($previousYearPurchasesSum ?: 1) * 100;

        // Format the percentages
        $saleYearly = round($salesIncreasePercentage, 2);
       $purchaseYearly = round($purchasesIncreasePercentage, 2);

        return view('admin.dashboard', compact('category', 'supplier', 'product', 'user', 'customer', 'sale', 'purchase', 'products', 'customerPercentage', 'supplierPercentage', 'userPercentage', 'productPercentage', 'salePercentage', 'purchasePercentage', 'categoryPercentage', 'salePaymentPercentage','saleData', 'purchaseData', 'months', 'saleYearly', 'purchaseYearly','payment'));
    }

    public function categoryPercentage(){
        // Get the date for yesterday
        $yesterday = Carbon::yesterday()->toDateString();

        // Count of categories for yesterday
        $categoriesYesterdayCount = Category::whereDate('created_at', $yesterday)->count();

        // Count of categories for today
        $categoriesTodayCount = Category::whereDate('created_at', Carbon::today())->count();
        // dd($categoriesTodayCount);
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
        // Query for supplier count since last week
        $supplierCount = Supplier::where('created_at', '>=', $startOfLastWeek)
            ->count();

        // Calculate the percentage change
        if ($supplierCount > 0) {
            $supplierPercentage = $supplierCount;
        } else {
            // Handle division by zero
            $supplierPercentage = 0;
        }
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

        // Calculate the percentage change
        if ($previousMonthUserCount > 0) {
            $userPercentage = (($currentMonthUserCount - $previousMonthUserCount) / $previousMonthUserCount) * 100;
        } else {
            // Handle division by zero
            $userPercentage = 0;
        }

        return round($userPercentage, 2);
    }

    public function customerPercentage($customer){
        $yesterdayStart = Carbon::yesterday()->startOfDay();
        $countSinceYesterday = Customer::where('status', 1)
        ->where('created_at', '>=', $yesterdayStart)
        ->count();

        // Calculate the percentage
        if ($customer > 0) {
            $customerPercentage = $countSinceYesterday;
        } else {
            $customerPercentage = 0; // Avoid division by zero
        }
        return round($customerPercentage, 2);
    }

    public function salePercentage(){
        $currentQuarterStart = Carbon::now()->startOfQuarter();
        $currentQuarterEnd = Carbon::now()->endOfQuarter();

        // Query for total sale count within the specified date range
        $salePercentage = Sale::whereBetween('created_at', [$currentQuarterStart, $currentQuarterEnd])->sum('received_amount');

        return round($salePercentage, 2);
    }

    public function purchasePercentage(){
        $currentQuarterStart = Carbon::now()->startOfQuarter();
        $currentQuarterEnd = Carbon::now()->endOfQuarter();
        $purchasePercentage = Purchase::whereBetween('created_at', [$currentQuarterStart, $currentQuarterEnd])->sum('amount');
        return round($purchasePercentage, 2);
    }

    public function salePaymentPercentage(){
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();
        $previousWeekStart = Carbon::now()->endOfWeek()->subWeek();
        $previousWeekEnd = Carbon::now()->endOfWeek()->subWeek();
        $currentWeekTotalPayment = Sale::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->sum('received_amount');

        // Total payment amount for the previous week
        $previousWeekTotalPayment = Sale::whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])->sum('received_amount');

        // Calculate the percentage change
        if ($previousWeekTotalPayment > 0) {
            $salePaymentPercentage = (($currentWeekTotalPayment - $previousWeekTotalPayment) / $previousWeekTotalPayment) * 100;
        } else {
            // Handle division by zero
            $salePaymentPercentage = 0;
        }

        return round($salePaymentPercentage, 2);
    }

    public function productPercentage(){
        $startDate = Carbon::now()->startOfQuarter()->subMonths(3);
        $endDate = Carbon::now()->endOfQuarter()->subMonths(3);

        // Query for products with status 1 within the specified date range
        $productPercentage = Product::where('status', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();


        return round($productPercentage,0);
    }
}
