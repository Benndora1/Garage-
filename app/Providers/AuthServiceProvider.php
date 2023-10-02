<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        $this->registerPostPolicies();
    }


    public function registerPostPolicies()
    {
        Gate::before(function($user, $ability) {
            
            if(isAdmin($user->role_id))
            {     
                return true;
            }
        });


        //For Vehicle Module Policy (Define by Mukesh)
        Gate::define('vehicle_view', function ($user) {
            return $user->hasAccess(['vehicle_view']);
        });

        Gate::define('vehicle_add', function ($user) {
            return $user->hasAccess(['vehicle_add']);
        });

        Gate::define('vehicle_edit', function ($user) {
            return $user->hasAccess(['vehicle_edit']);
        });

        Gate::define('vehicle_delete', function ($user) {
            return $user->hasAccess(['vehicle_delete']);
        });

        Gate::define('vehicle_owndata', function ($user) {
            return $user->hasAccess(['vehicle_owndata']);
        });

        //For Supplier Module Policy (Define by Mukesh)
        Gate::define('supplier_view', function ($user) {
            return $user->hasAccess(['supplier_view']);
        });

        Gate::define('supplier_add', function ($user) {
            return $user->hasAccess(['supplier_add']);
        });

        Gate::define('supplier_edit', function ($user) {
            return $user->hasAccess(['supplier_edit']);
        });

        Gate::define('supplier_delete', function ($user) {
            return $user->hasAccess(['supplier_delete']);
        });

        Gate::define('supplier_owndata', function ($user) {
            return $user->hasAccess(['supplier_owndata']);
        });


        //For Product Module Policy (Define by Mukesh)
        Gate::define('product_view', function ($user) {
            return $user->hasAccess(['product_view']);
        });
        Gate::define('product_add', function ($user) {
            return $user->hasAccess(['product_add']);
        });
        Gate::define('product_edit', function ($user) {
            return $user->hasAccess(['product_edit']);
        });
        Gate::define('product_delete', function ($user) {
            return $user->hasAccess(['product_delete']);
        });
        Gate::define('product_owndata', function ($user) {
            return $user->hasAccess(['product_owndata']);
        });


        //For Purchase Module Policy (Define by Mukesh)
        Gate::define('purchase_view', function ($user) {
            return $user->hasAccess(['purchase_view']);
        });
        Gate::define('purchase_add', function ($user) {
            return $user->hasAccess(['purchase_add']);
        });
        Gate::define('purchase_edit', function ($user) {
            return $user->hasAccess(['purchase_edit']);
        });
        Gate::define('purchase_delete', function ($user) {
            return $user->hasAccess(['purchase_delete']);
        });
        Gate::define('purchase_owndata', function ($user) {
            return $user->hasAccess(['purchase_owndata']);
        });


        //For Stock Module Policy (Define by Mukesh)
        Gate::define('stock_view', function ($user) {
            return $user->hasAccess(['stock_view']);
        });
        Gate::define('stock_add', function ($user) {
            return $user->hasAccess(['stock_add']);
        });
        Gate::define('stock_edit', function ($user) {
            return $user->hasAccess(['stock_edit']);
        });
        Gate::define('stock_delete', function ($user) {
            return $user->hasAccess(['stock_delete']);
        });
        Gate::define('stock_owndata', function ($user) {
            return $user->hasAccess(['stock_owndata']);
        });


        //For Dashboard Module Policy (Define by Mukesh)
        Gate::define('dashboard_view', function ($user) {
            return $user->hasAccess(['dashboard_view']);
        });
        Gate::define('dashboard_owndata', function ($user) {
            return $user->hasAccess(['dashboard_owndata']);
        });


        //For Customer Module Policy (Define by Mukesh)
        Gate::define('customer_view', function ($user) {
            return $user->hasAccess(['customer_view']);
        });
        Gate::define('customer_add', function ($user) {
            return $user->hasAccess(['customer_add']);
        });
        Gate::define('customer_edit', function ($user) {
            return $user->hasAccess(['customer_edit']);
        });
        Gate::define('customer_delete', function ($user) {
            return $user->hasAccess(['customer_delete']);
        });
        Gate::define('customer_owndata', function ($user) {
            return $user->hasAccess(['customer_owndata']);
        });


        //For Employee Module Policy (Define by Mukesh)
        Gate::define('employee_view', function ($user) {
            return $user->hasAccess(['employee_view']);
        });
        Gate::define('employee_add', function ($user) {
            return $user->hasAccess(['employee_add']);
        });
        Gate::define('employee_edit', function ($user) {
            return $user->hasAccess(['employee_edit']);
        });
        Gate::define('employee_delete', function ($user) {
            return $user->hasAccess(['employee_delete']);
        });
        Gate::define('employee_owndata', function ($user) {
            return $user->hasAccess(['employee_owndata']);
        });


        //For Support Staff Module Policy (Define by Mukesh)
        Gate::define('supportstaff_view', function ($user) {
            return $user->hasAccess(['supportstaff_view']);
        });
        Gate::define('supportstaff_add', function ($user) {
            return $user->hasAccess(['supportstaff_add']);
        });
        Gate::define('supportstaff_edit', function ($user) {
            return $user->hasAccess(['supportstaff_edit']);
        });
        Gate::define('supportstaff_delete', function ($user) {
            return $user->hasAccess(['supportstaff_delete']);
        });
        Gate::define('supportstaff_owndata', function ($user) {
            return $user->hasAccess(['supportstaff_owndata']);
        });


        //For Accountant Module Policy (Define by Mukesh)
        Gate::define('accountant_view', function ($user) {
            return $user->hasAccess(['accountant_view']);
        });
        Gate::define('accountant_add', function ($user) {
            return $user->hasAccess(['accountant_add']);
        });
        Gate::define('accountant_edit', function ($user) {
            return $user->hasAccess(['accountant_edit']);
        });
        Gate::define('accountant_delete', function ($user) {
            return $user->hasAccess(['accountant_delete']);
        });
        Gate::define('accountant_owndata', function ($user) {
            return $user->hasAccess(['accountant_owndata']);
        });


        //For VehicleType Module Policy (Define by Mukesh)
        Gate::define('vehicletype_view', function ($user) {
            return $user->hasAccess(['vehicletype_view']);
        });
        Gate::define('vehicletype_add', function ($user) {
            return $user->hasAccess(['vehicletype_add']);
        });
        Gate::define('vehicletype_edit', function ($user) {
            return $user->hasAccess(['vehicletype_edit']);
        });
        Gate::define('vehicletype_delete', function ($user) {
            return $user->hasAccess(['vehicletype_delete']);
        });
        Gate::define('vehicletype_owndata', function ($user) {
            return $user->hasAccess(['vehicletype_owndata']);
        });


        //For VehicleBrand Module Policy (Define by Mukesh)
        Gate::define('vehiclebrand_view', function ($user) {
            return $user->hasAccess(['vehiclebrand_view']);
        });
        Gate::define('vehiclebrand_add', function ($user) {
            return $user->hasAccess(['vehiclebrand_add']);
        });
        Gate::define('vehiclebrand_edit', function ($user) {
            return $user->hasAccess(['vehiclebrand_edit']);
        });
        Gate::define('vehiclebrand_delete', function ($user) {
            return $user->hasAccess(['vehiclebrand_delete']);
        });
        Gate::define('vehiclebrand_owndata', function ($user) {
            return $user->hasAccess(['vehiclebrand_owndata']);
        });


        //For Colors Module Policy (Define by Mukesh)
        Gate::define('colors_view', function ($user) {
            return $user->hasAccess(['colors_view']);
        });
        Gate::define('colors_add', function ($user) {
            return $user->hasAccess(['colors_add']);
        });
        Gate::define('colors_edit', function ($user) {
            return $user->hasAccess(['colors_edit']);
        });
        Gate::define('colors_delete', function ($user) {
            return $user->hasAccess(['colors_delete']);
        });
        Gate::define('colors_owndata', function ($user) {
            return $user->hasAccess(['colors_owndata']);
        });


        //For Service Module Policy (Define by Mukesh)
        Gate::define('service_view', function ($user) {
            return $user->hasAccess(['service_view']);
        });
        Gate::define('service_add', function ($user) {
            return $user->hasAccess(['service_add']);
        });
        Gate::define('service_edit', function ($user) {
            return $user->hasAccess(['service_edit']);
        });
        Gate::define('service_delete', function ($user) {
            return $user->hasAccess(['service_delete']);
        });
        Gate::define('service_owndata', function ($user) {
            return $user->hasAccess(['service_owndata']);
        });


        //For Invoice Module Policy (Define by Mukesh)
        Gate::define('invoice_view', function ($user) {
            return $user->hasAccess(['invoice_view']);
        });
        Gate::define('invoice_add', function ($user) {
            return $user->hasAccess(['invoice_add']);
        });
        Gate::define('invoice_edit', function ($user) {
            return $user->hasAccess(['invoice_edit']);
        });
        Gate::define('invoice_delete', function ($user) {
            return $user->hasAccess(['invoice_delete']);
        });
        Gate::define('invoice_owndata', function ($user) {
            return $user->hasAccess(['invoice_owndata']);
        });


        //For Jobcard Module Policy (Define by Mukesh)
        Gate::define('jobcard_view', function ($user) {
            return $user->hasAccess(['jobcard_view']);
        });
        Gate::define('jobcard_add', function ($user) {
            return $user->hasAccess(['jobcard_add']);
        });
        Gate::define('jobcard_edit', function ($user) {
            return $user->hasAccess(['jobcard_edit']);
        });
        Gate::define('jobcard_delete', function ($user) {
            return $user->hasAccess(['jobcard_delete']);
        });
        Gate::define('jobcard_owndata', function ($user) {
            return $user->hasAccess(['jobcard_owndata']);
        });
        

        //For Gatepass Module Policy (Define by Mukesh)
        Gate::define('gatepass_view', function ($user) {
            return $user->hasAccess(['gatepass_view']);
        });
        Gate::define('gatepass_add', function ($user) {
            return $user->hasAccess(['gatepass_add']);
        });
        Gate::define('gatepass_edit', function ($user) {
            return $user->hasAccess(['gatepass_edit']);
        });
        Gate::define('gatepass_delete', function ($user) {
            return $user->hasAccess(['gatepass_delete']);
        });
        Gate::define('gatepass_owndata', function ($user) {
            return $user->hasAccess(['gatepass_owndata']);
        });

        //For Tax Rate Module Policy (Define by Mukesh)
        Gate::define('taxrate_view', function ($user) {
            return $user->hasAccess(['taxrate_view']);
        });
        Gate::define('taxrate_add', function ($user) {
            return $user->hasAccess(['taxrate_add']);
        });
        Gate::define('taxrate_edit', function ($user) {
            return $user->hasAccess(['taxrate_edit']);
        });
        Gate::define('taxrate_delete', function ($user) {
            return $user->hasAccess(['taxrate_delete']);
        });
        Gate::define('taxrate_owndata', function ($user) {
            return $user->hasAccess(['taxrate_owndata']);
        });

        //For Payment Method Module Policy (Define by Mukesh)
        Gate::define('paymentmethod_view', function ($user) {
            return $user->hasAccess(['paymentmethod_view']);
        });
        Gate::define('paymentmethod_add', function ($user) {
            return $user->hasAccess(['paymentmethod_add']);
        });
        Gate::define('paymentmethod_edit', function ($user) {
            return $user->hasAccess(['paymentmethod_edit']);
        });
        Gate::define('paymentmethod_delete', function ($user) {
            return $user->hasAccess(['paymentmethod_delete']);
        });
        Gate::define('paymentmethod_owndata', function ($user) {
            return $user->hasAccess(['paymentmethod_owndata']);
        });

        //For Income Module Policy (Define by Mukesh)
        Gate::define('income_view', function ($user) {
            return $user->hasAccess(['income_view']);
        });
        Gate::define('income_add', function ($user) {
            return $user->hasAccess(['income_add']);
        });
        Gate::define('income_edit', function ($user) {
            return $user->hasAccess(['income_edit']);
        });
        Gate::define('income_delete', function ($user) {
            return $user->hasAccess(['income_delete']);
        });
        Gate::define('income_owndata', function ($user) {
            return $user->hasAccess(['income_owndata']);
        });

        //For Expense Module Policy (Define by Mukesh)
        Gate::define('expense_view', function ($user) {
            return $user->hasAccess(['expense_view']);
        });
        Gate::define('expense_add', function ($user) {
            return $user->hasAccess(['expense_add']);
        });
        Gate::define('expense_edit', function ($user) {
            return $user->hasAccess(['expense_edit']);
        });
        Gate::define('expense_delete', function ($user) {
            return $user->hasAccess(['expense_delete']);
        });
        Gate::define('expense_owndata', function ($user) {
            return $user->hasAccess(['expense_owndata']);
        });

        //For Sales Module Policy (Define by Mukesh)
        Gate::define('sales_view', function ($user) {
            return $user->hasAccess(['sales_view']);
        });
        Gate::define('sales_add', function ($user) {
            return $user->hasAccess(['sales_add']);
        });
        Gate::define('sales_edit', function ($user) {
            return $user->hasAccess(['sales_edit']);
        });
        Gate::define('sales_delete', function ($user) {
            return $user->hasAccess(['sales_delete']);
        });
        Gate::define('sales_owndata', function ($user) {
            return $user->hasAccess(['sales_owndata']);
        });

        //For Sales Part Module Policy (Define by Mukesh)
        Gate::define('salespart_view', function ($user) {
            return $user->hasAccess(['salespart_view']);
        });
        Gate::define('salespart_add', function ($user) {
            return $user->hasAccess(['salespart_add']);
        });
        Gate::define('salespart_edit', function ($user) {
            return $user->hasAccess(['salespart_edit']);
        });
        Gate::define('salespart_delete', function ($user) {
            return $user->hasAccess(['salespart_delete']);
        });
        Gate::define('salespart_owndata', function ($user) {
            return $user->hasAccess(['salespart_owndata']);
        });

        //For  Rto Policy (Define by Mukesh)
        Gate::define('rto_view', function ($user) {
            return $user->hasAccess(['rto_view']);
        });
        Gate::define('rto_add', function ($user) {
            return $user->hasAccess(['rto_add']);
        });
        Gate::define('rto_edit', function ($user) {
            return $user->hasAccess(['rto_edit']);
        });
        Gate::define('rto_delete', function ($user) {
            return $user->hasAccess(['rto_delete']);
        });
        Gate::define('rto_owndata', function ($user) {
            return $user->hasAccess(['rto_owndata']);
        });

        //For Reports Module Policy (Define by Mukesh)
        Gate::define('report_view', function ($user) {
            return $user->hasAccess(['report_view']);
        });
        Gate::define('report_add', function ($user) {
            return $user->hasAccess(['report_add']);
        });
        Gate::define('report_edit', function ($user) {
            return $user->hasAccess(['report_edit']);
        });
        Gate::define('report_delete', function ($user) {
            return $user->hasAccess(['report_delete']);
        });
        Gate::define('report_owndata', function ($user) {
            return $user->hasAccess(['report_owndata']);
        });

        //For  Email Template Module Policy (Define by Mukesh)
        Gate::define('emailtemplate_view', function ($user) {
            return $user->hasAccess(['emailtemplate_view']);
        });
        Gate::define('emailtemplate_add', function ($user) {
            return $user->hasAccess(['emailtemplate_add']);
        });
        Gate::define('emailtemplate_edit', function ($user) {
            return $user->hasAccess(['emailtemplate_edit']);
        });
        Gate::define('emailtemplate_delete', function ($user) {
            return $user->hasAccess(['emailtemplate_delete']);
        });
        Gate::define('emailtemplate_owndata', function ($user) {
            return $user->hasAccess(['emailtemplate_owndata']);
        });

        //For  Custom Field Module Policy (Define by Mukesh)
        Gate::define('customfield_view', function ($user) {
            return $user->hasAccess(['customfield_view']);
        });
        Gate::define('customfield_add', function ($user) {
            return $user->hasAccess(['customfield_add']);
        });
        Gate::define('customfield_edit', function ($user) {
            return $user->hasAccess(['customfield_edit']);
        });
        Gate::define('customfield_delete', function ($user) {
            return $user->hasAccess(['customfield_delete']);
        });
        Gate::define('customfield_owndata', function ($user) {
            return $user->hasAccess(['customfield_owndata']);
        });

        //For Observation Library Module Policy (Define by Mukesh)
        Gate::define('observationlibrary_view', function ($user) {
            return $user->hasAccess(['observationlibrary_view']);
        });
        Gate::define('observationlibrary_add', function ($user) {
            return $user->hasAccess(['observationlibrary_add']);
        });
        Gate::define('observationlibrary_edit', function ($user) {
            return $user->hasAccess(['observationlibrary_edit']);
        });
        Gate::define('observationlibrary_delete', function ($user) {
            return $user->hasAccess(['observationlibrary_delete']);
        });
        Gate::define('observationlibrary_owndata', function ($user) {
            return $user->hasAccess(['observationlibrary_owndata']);
        });

        //For  General Settings Module Policy (Define by Mukesh)
        Gate::define('generalsetting_view', function ($user) {
            return $user->hasAccess(['generalsetting_view']);
        });
        Gate::define('generalsetting_edit', function ($user) {
            return $user->hasAccess(['generalsetting_edit']);
        });

        //For Timezone Module Policy (Define by Mukesh)
        Gate::define('timezone_view', function ($user) {
            return $user->hasAccess(['timezone_view']);
        });
        Gate::define('timezone_edit', function ($user) {
            return $user->hasAccess(['timezone_edit']);
        });
        
        //For Language Module Policy (Define by Mukesh)
        Gate::define('language_view', function ($user) {
            return $user->hasAccess(['language_view']);
        });
        Gate::define('language_edit', function ($user) {
            return $user->hasAccess(['language_edit']);
        });

        //For Date Format Module Policy (Define by Mukesh)
        Gate::define('dateformat_view', function ($user) {
            return $user->hasAccess(['dateformat_view']);
        });
        Gate::define('dateformat_edit', function ($user) {
            return $user->hasAccess(['dateformat_edit']);
        });

        //For Currency Module Policy (Define by Mukesh)
        Gate::define('currency_view', function ($user) {
            return $user->hasAccess(['currency_view']);
        });
        Gate::define('currency_edit', function ($user) {
            return $user->hasAccess(['currency_edit']);
        });
        
        //For Access Rights Module Policy (Define by Mukesh)
        Gate::define('accessrights_view', function ($user) {
            return $user->hasAccess(['accessrights_view']);
        });
        Gate::define('accessrights_edit', function ($user) {
            return $user->hasAccess(['accessrights_edit']);
        });
        
        //For Business Hours Module Policy (Define by Mukesh)
        Gate::define('businesshours_view', function ($user) {
            return $user->hasAccess(['businesshours_view']);
        });
        Gate::define('businesshours_add', function ($user) {
            return $user->hasAccess(['businesshours_add']);
        });
        Gate::define('businesshours_delete', function ($user) {
            return $user->hasAccess(['businesshours_delete']);
        });

        //For Stripe Setting Module Policy (Define by Mukesh)
        Gate::define('stripesetting_view', function ($user) {
            return $user->hasAccess(['stripesetting_view']);
        });
        Gate::define('stripesetting_edit', function ($user) {
            return $user->hasAccess(['stripesetting_edit']);
        });


        //For Quotation Module Policy (Define by Mukesh)
        Gate::define('quotation_view', function ($user) {
            return $user->hasAccess(['quotation_view']);
        });
        Gate::define('quotation_add', function ($user) {
            return $user->hasAccess(['quotation_add']);
        });
        Gate::define('quotation_edit', function ($user) {
            return $user->hasAccess(['quotation_edit']);
        });
        Gate::define('quotation_delete', function ($user) {
            return $user->hasAccess(['quotation_delete']);
        });

    }
}
