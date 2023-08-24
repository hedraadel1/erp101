<?php

namespace App\Http\Controllers;

use App\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\BusinessLocation;
use App\PurchaseLine;
use App\Transaction;
use App\TransactionSellLinesPurchaseLines;
use App\Utils\ModuleUtil;

use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use Datatables;
use Illuminate\Support\Facades\DB; // this will import the DB facade into your controller class

//use DB;
use Spatie\Activitylog\Models\Activity;



use App\AccountTransaction;
use App\Business;
use App\Contact;
use App\CustomerGroup;
use App\Product;
use App\TaxRate;
use App\User;
use App\Utils\BusinessUtil;
use Illuminate\Support\Facades\Hash;


use App\Variation;
use Excel;
class ValidateInvoiceDataController extends Controller
{
    public static function index(Request $request,$id){

            $business_id = $request->session()->get('user.business_id');
            $Issuer_type="B";
            $Issuer_id=DB::table('business')->where('id', $business_id)->value('tax_number_1');
            $Issuer_name = DB::table('business')->where('id', $business_id)->value('name');
            $Issuer_address_branch_id =DB::table('transactions')->where('id', $id)->where('business_id',$business_id )->value('location_id');
            $Issuer_address_country =DB::table('business_locations')->where('business_id', $business_id)->where('id',  $Issuer_address_branch_id)->value('country');
            $Issuer_address_governate =DB::table('business_locations')->where('business_id', $business_id)->where('id',  $Issuer_address_branch_id)->value('state');
            $Issuer_address_regionCity =DB::table('business_locations')->where('business_id', $business_id)->where('id',  $Issuer_address_branch_id)->value('city');
            $Issuer_address_street =DB::table('business_locations')->where('business_id', $business_id)->where('id',  $Issuer_address_branch_id)->value('custom_field1');
            $Issuer_address_buildingNumber=DB::table('business_locations')->where('business_id', $business_id)->where('id',  $Issuer_address_branch_id)->value('custom_field2');
            $Receiver_type="P";
			      $contact_id =DB::table('transactions')->where('id', $id)->where('business_id',$business_id )->value('contact_id');
			      $Receiver_id=DB::table('contacts')->where('id', $contact_id)->value('tax_number');
			      $Receiver_name =DB::table('contacts')->where('id', $contact_id)->value('name');
            $Receiver_address_country =DB::table('contacts')->where('id', $contact_id)->value('country');
            $Receiver_address_governate =DB::table('contacts')->where('id', $contact_id)->value('state');
            $Receiver_address_regionCity =DB::table('contacts')->where('id', $contact_id)->value('city');
            $Receiver_address_street =DB::table('contacts')->where('id', $contact_id)->value('address_line_1');
            $Receiver_address_buildingNumber=DB::table('contacts')->where('id', $contact_id)->value('address_line_2');
           
			// if($Issuer_id==null|| $Issuer_name==null || $Issuer_address_country==null || $Issuer_address_governate==null || $Issuer_address_regionCity==null ||  $Issuer_address_street==null ||  $Issuer_address_buildingNumber==null ||
			// $Receiver_id==null ||$Receiver_name==null ||  $Receiver_address_country==null|| $Receiver_address_governate==null || $Receiver_address_regionCity==null||$Receiver_address_street==null||$Receiver_address_buildingNumber==null)
			// {
			// 	return "من فضلك اكمل ادخال البيانات";
			// }




            $documentType="i";
            $documentTypeVersion="1.0";
            $dateTimeIssued=DB::table('transactions')->where('id', $id)->where('business_id',$business_id )->value('transaction_date');
            $taxpayerActivityCode=DB::table('business_locations')->where('business_id', $business_id)->where('id',  $Issuer_address_branch_id)->value('location_id');
            $internalId=DB::table('transactions')->where('id', $id)->where('business_id',$business_id )->value('invoice_no');
            $products_id=DB::table('transaction_sell_lines')->where('transaction_id', $id)->pluck('product_id');
			      $Invoice_line_description=DB::table('products')->whereIn('id',  $products_id)->pluck('name');
            $Invoice_line_itemType="GS1";
            $Invoice_line_itemCode="10003752";
            $unit_id=DB::table('products')->whereIn('id',  $products_id)->pluck('unit_id');
			//$Invoice_line_unitType=DB::table('units')->whereIn('id',  $unit_id)->pluck('short_name');
			$Invoice_line_unitType="PC(S)";
            $Invoice_line_quantity=DB::table('transaction_sell_lines')->where('transaction_id', $id)->pluck('quantity');
			$Invoice_line_unitValue_currencySold="EGP";
            $Invoice_line_unitValue_amountEGP=DB::table('transaction_sell_lines')->where('transaction_id', $id)->pluck('unit_price_before_discount');
			$Invoice_line_unitValue_amountSold=null;
            $Invoice_line_unitValue_currencyExchangeRate=null;
			$Invoice_line_salesTotal=[];
			$Invoice_line_unitValue_amountEGP_include_tax=DB::table('transaction_sell_lines')->where('transaction_id', $id)->pluck('unit_price_inc_tax');
			$Invoice_line_unitValue_amountEGP_include_discount=DB::table('transaction_sell_lines')->where('transaction_id', $id)->pluck('unit_price');
			$Invoice_line_total=[];
			$Invoice_line_valueDifference=[];
			$all_discounts=[];
			$Invoice_line_itemsDiscount=DB::table('transaction_sell_lines')->where('transaction_id', $id)->pluck('line_discount_amount');
			$Invoice_line_itemsDiscount_array=[];
            $item_taxes=DB::table('transaction_sell_lines')->where('transaction_id', $id)->pluck('item_tax');
			$item_taxes_array=[];
			$Invoice_line_netTotal=[];
			$Invoice_line_totalTaxableFees=0.0;
			$invoice_lines=[];

			$i=0;
			while ($i<count($products_id)){

				$Invoice_line_quantity[$i]=floatVal($Invoice_line_quantity[$i]);
				$Invoice_line_unitValue_amountEGP[$i]=floatVal($Invoice_line_unitValue_amountEGP[$i]);
				$item_taxes[$i]=floatVal($item_taxes[$i]);
				$Invoice_line_itemsDiscount_array[$i]=floatVal($Invoice_line_itemsDiscount[$i]);
				$Invoice_line_salesTotal[$i]=$Invoice_line_unitValue_amountEGP[$i]*$Invoice_line_quantity[$i];
				$Invoice_line_unitValue_amountEGP_include_tax[$i]=floatVal($Invoice_line_unitValue_amountEGP_include_tax[$i]);
				$Invoice_line_unitValue_amountEGP_include_discount[$i]=floatVal($Invoice_line_unitValue_amountEGP_include_discount[$i]);
				$item_taxes_array[$i]=$item_taxes[$i]*$Invoice_line_quantity[$i];
				$Invoice_line_total[$i]=$Invoice_line_unitValue_amountEGP_include_tax[$i]*$Invoice_line_quantity[$i];
				$all_discounts[$i]=$Invoice_line_itemsDiscount_array[$i]*$Invoice_line_quantity[$i];
				$Invoice_line_valueDifference[$i]=0.0;
				$Invoice_line_netTotal[$i]=$Invoice_line_unitValue_amountEGP_include_discount[$i]*$Invoice_line_quantity[$i];
				$line=[
					
					"description" =>$Invoice_line_description[$i] ,
					"itemType" => $Invoice_line_itemType,
					"itemCode" => $Invoice_line_itemCode,
					"unitType" => $Invoice_line_unitType,
					"quantity" => floatval($Invoice_line_quantity[$i]),
					"internalCode" => null,
					"salesTotal" => $Invoice_line_salesTotal[$i],
					"total" => $Invoice_line_total[$i],
					"valueDifference" => $Invoice_line_valueDifference[$i],
					"totalTaxableFees" =>$Invoice_line_totalTaxableFees,
					"netTotal" => $Invoice_line_netTotal[$i],
					"itemsDiscount" => $Invoice_line_itemsDiscount_array[$i],
					"unitValue" => [
						"currencySold" => $Invoice_line_unitValue_currencySold,
						"amountEGP" => $Invoice_line_unitValue_amountEGP[$i],
					],
					
					"discount" => ["rate" => null, "amount" => null],
					"taxableItems" => [
						[
							"taxType" => null,
							"amount" => null,
							"subType" => null,
							"rate" => null,
						],
					],
					
				];
				array_push($invoice_lines,$line);

			    $i++;
			}
            $totalSalesAmount=array_sum($Invoice_line_salesTotal);
            $totalDiscountAmount=array_sum($Invoice_line_itemsDiscount_array);
            $netAmount=array_sum($Invoice_line_netTotal);;
            $taxTotals_taxType="123";
            $taxTotals_amount=array_sum($item_taxes_array);
            $extraDiscountAmount=$totalDiscountAmount;
            $totalItemsDiscountAmount= array_sum($all_discounts);
            $totalAmount=array_sum($Invoice_line_total);
            $signatures_type="I";
            $signatures_value="Base64 encoded string";	
			
			
			
			$documentArr = [
				"documents" => [
					[
						"issuer" => [
							"address" => [
								"branchID" => (string)$Issuer_address_branch_id,
								"country" =>(string) $Issuer_address_country,
								"governate" => (string)$Issuer_address_governate,
								"regionCity" => (string) $Issuer_address_regionCity,
								"street" => (string)$Issuer_address_street,
								"buildingNumber" =>(string) $Issuer_address_buildingNumber,
								"postalCode" => null,
								"floor" => null,
								"room" => null,
								"landmark" => null,
								"additionalInformation" => null,
							],
							"type" =>(string) $Issuer_type,
							"id" =>(string) $Issuer_id,
							"name" =>(string) $Issuer_name,
						],
						"receiver" => [
							"address" => [
								"country" => (string)$Receiver_address_country,
								"governate" => (string) $Receiver_address_governate,
								"regionCity" =>(string) $Receiver_address_regionCity,
								"street" => (string) $Receiver_address_street,
								"buildingNumber" =>(string) $Receiver_address_buildingNumber,
								"postalCode" => null,
								"floor" => null,
								"room" => null,
								"landmark" => null,
								"additionalInformation" => null,
							],
							"type" => (string)$Receiver_type,
							"id" =>(string) $Receiver_id,
							"name" => (string)$Receiver_name,
						],
						"documentType" => (string)$documentType,
						"documentTypeVersion" => (string)$documentTypeVersion,
						"dateTimeIssued" =>$dateTimeIssued,
						"taxpayerActivityCode" =>(string) $taxpayerActivityCode,
						"internalID" => (string)$internalId,
						"purchaseOrderReference" => null,
						"purchaseOrderDescription" => null,
						"salesOrderReference" => null,
						"salesOrderDescription" => null,
						"proformaInvoiceNumber" => null,
						"payment" => [
							"bankName" => null,
							"bankAddress" => null,
							"bankAccountNo" => null,
							"bankAccountIBAN" => null,
							"swiftCode" => null,
							"terms" => null,
						],
						"delivery" => [
							"approach" => null,
							"packaging" => null,
							"dateValidity" => null,
							"exportPort" => null,
							"grossWeight" => null,
							"netWeight" => null,
							"terms" => null,
						],
						"invoiceLines" => $invoice_lines,
						"totalDiscountAmount" => $totalDiscountAmount,
						"totalSalesAmount" =>  $totalSalesAmount,
						"netAmount" => $netAmount,
						"taxTotals" => [["taxType" =>$taxTotals_taxType, "amount" => $taxTotals_amount]],
						"totalAmount" => $totalAmount,
						"extraDiscountAmount" => $extraDiscountAmount,
						"totalItemsDiscountAmount" => $totalItemsDiscountAmount,
						"signatures" => [
							[
								"signatureType" => $signatures_type,
								"value" =>$signatures_value
							],
						],
					],
				],
			];
			
			// Convert the data to JSON format
			$json = json_encode($documentArr, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			
			// Define the file name and path
			$filename = 'eInvoices/invoiceDocument.json';
			$filepath = storage_path($filename);
			// Save the JSON data to a file on the server
			file_put_contents($filepath, $json);
			
			// Download the file to the user's computer
			return response()->download($filepath);

			
       }




}
