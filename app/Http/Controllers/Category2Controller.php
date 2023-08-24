<?php
	
	namespace App\Http\Controllers;
	
	use App\Category2;
	use App\Utils\ModuleUtil;
	use Illuminate\Http\Request;
	use Yajra\DataTables\Facades\DataTables;
	use Illuminate\Support\Facades\Log;
	
	class Category2Controller extends Controller
	{
		/**
		 * All Utils instance.
		 *
		 */
		protected $moduleUtil;
		
		/**
		 * Constructor
		 *
		 * @param ProductUtils $product
		 * @return void
		 */
		public function __construct(ModuleUtil $moduleUtil)
		{
			$this->moduleUtil = $moduleUtil;
		}
		
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			if (!auth()->user()->can('category.view') && !auth()->user()->can('category.create')) {
				abort(403, 'Unauthorized action.');
			}
			
			if (request()->ajax()) {
				$business_id = request()->session()->get('user.business_id');
				
				$category2 = category2::where('business_id', $business_id)
					->select(['name', 'description', 'id']);
				
				
				return Datatables::of($category2)
					->addColumn(
						'action',
						'@can("category.update")
                    <button data-href="{{action(\'Category2Controller@edit\', [$id])}}" class="btn Btn-Brand Btn-bx  Btn-Primary edit_category2_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                    @endcan
                    @can("category.delete")
                        <button data-href="{{action(\'Category2Controller@destroy\', [$id])}}" class="btn Btn-Brand Btn-bx  btn-danger delete_category2_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan'
					)
					->removeColumn('id')
					->rawColumns([2])
					->make(false);
			}
			
			return view('category2.index');
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			if (!auth()->user()->can('category.create')) {
				abort(403, 'Unauthorized action.');
			}
			
			$quick_add = false;
			if (!empty(request()->input('quick_add'))) {
				$quick_add = true;
			}
			
			return view('category2.create')
				->with(compact('quick_add'));
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			if (!auth()->user()->can('category.create')) {
				abort(403, 'Unauthorized action.');
			}
			
			try {
				$input = $request->only(['name', 'description']);
				$business_id = $request->session()->get('user.business_id');
				$input['business_id'] = $business_id;
				$input['created_by'] = $request->session()->get('user.id');
				
				
				$category2 = category2::create($input);
				$output = ['success' => true,
					'data' => $category2,
					'msg' => __("category2.added_success")
				];
			} catch (\Exception $e) {
				\Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
				
				$output = ['success' => false,
					'msg' => __("messages.something_went_wrong")
				];
			}
			
			return $output;
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			//
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			if (!auth()->user()->can('category.update')) {
				abort(403, 'Unauthorized action.');
			}
			
			if (request()->ajax()) {
				$business_id = request()->session()->get('user.business_id');
				$category2 = category2::where('business_id', $business_id)->find($id);
				
				
				return view('category2.edit')
					->with(compact('category2'));
			}
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
			if (!auth()->user()->can('category.update')) {
				abort(403, 'Unauthorized action.');
			}
			
			if (request()->ajax()) {
				try {
					$input = $request->only(['name', 'description']);
					$business_id = $request->session()->get('user.business_id');
					
					$category2 = category2::where('business_id', $business_id)->findOrFail($id);
					$category2->name = $input['name'];
					$category2->description = $input['description'];
					
					// if ($this->moduleUtil->isModuleInstalled('Repair')) {
					// 	$category2->use_for_repair = !empty($request->input('use_for_repair')) ? 1 : 0;
					// }
					
					$category2->save();
					
					$output = ['success' => true,
						'msg' => __("category2.updated_success")
					];
				} catch (\Exception $e) {
					\Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
					// dd($e);
					$output = ['success' => false,
						'msg' => __("messages.something_went_wrong")
					];
				}
				
				return $output;
			}
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			if (!auth()->user()->can('category.delete')) {
				abort(403, 'Unauthorized action.');
			}
			
			if (request()->ajax()) {
				try {
					$business_id = request()->user()->business_id;
					
					$category2 = category2::where('business_id', $business_id)->findOrFail($id);
					$category2->delete();
					
					$output = ['success' => true,
						'msg' => __("category.deleted_success")
					];
				} catch (\Exception $e) {
					\Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
					
					$output = ['success' => false,
						'msg' => __("messages.something_went_wrong")
					];
				}
				
				return $output;
			}
		}
		
		public function getcategory2Api()
		{
			try {
				$api_token = request()->header('API-TOKEN');
				
				$api_settings = $this->moduleUtil->getApiSettings($api_token);
				
				$category2 = category2::where('business_id', $api_settings->business_id)
					->get();
			} catch (\Exception $e) {
				\Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
				
				return $this->respondWentWrong($e);
			}
			
			return $this->respond($category2);
		}
	}
