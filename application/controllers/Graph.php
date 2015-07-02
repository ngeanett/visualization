<?php
class Graph extends CI_Controller {
		
		// Store the fields array used for bubble graphs
		private $bubble_fields = array();
		private $tree_fields = array();
		private $search_params = array();

		public function __construct()
        {
                parent::__construct();
                $this->load->model('graph_model');
                
                // Load the session library
                $this->load->library('session');
                
                // Load URL helper
                $this->load->helper('url');
                
                // TODO Load Other helpers (link, etc)
        }
        
        // Index page will show all of the graphs available
        public function index()
        {	
        	// variable used for title.
        	// Will change to report later
            $data['title'] = 'Visualization List'; 
			
			// Load the generic header
        	$this->load->view('templates/header', $data);
        	
        	// Load the main body
        	$this->load->view('graph/index', $data);
        	
        	// Load footer. Generic
        	$this->load->view('templates/footer', $data);
        }
        
        // Return a Bubble chart by cohort
        public function series_by_cohort()
        {
        	// Use the CHART NAME function to set all values passed into data model. 
        	// 	This includes: Query parameters, labels, fields, types, etc
        	
        	// Clear existing SESSION data from other charts
        	$this->session->unset_userdata('search_params');
        	$this->session->unset_userdata('bubble_fields');
        	
        	// Array used for uptions.
        	$options_array = array();
        	
            // variable used for title. Will change to report later
            $options_array['title'] = 'Utilization Rate by Cohort'; 
            $options_array['xaxis'] = 'TTM'; 
            $options_array['yaxis'] = 'Utilization Rate'; 
            
            // TODO Move this to a simple string and feed the JS later
            $options_array['options'] = NULL;
            
            // Construct search params and store in session
        	$this->search_params['table'] = 'utilization';
        	$this->search_params['where'] = array('utilization_rate <' => 4, 'utilization_rate !=' => 0);
        	$this->search_params['sort_col'] = 'cohort';
        	$this->search_params['sort_dir'] = 'ASC';
    		$this->session->set_userdata('search_params', $this->search_params);
            
			// Store the fields that will be used in the global variable.
			// They'll be used later when gathering data for the JSON call 
            $this->bubble_fields[] = array('field' => 'member_name', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'ttm', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'utilization_rate', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'cohort', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'enrollment', 'type' => 'number');
            
            // The bubble_fields array will be picked up on the recursive call for the JSON 
            // post in CHART_NAME_data
    		$this->session->set_userdata('bubble_fields', $this->bubble_fields);
			
			// Load the header with the java script.
			// Will move to JS folder later
        	$this->build_bubble_page($options_array);
        }
        
    	// Return a Bubble chart by sis
        public function series_by_sis()
        {
        	// Use the CHART NAME function to set all values passed into data model. 
        	// 	This includes: Query parameters, labels, fields, types, etc
        	
        	// Clear existing SESSION data from other charts
        	$this->session->unset_userdata('search_params');
        	$this->session->unset_userdata('bubble_fields');
        	
        	// Array used for uptions.
        	$options_array = array();
        	
            // variable used for title. Will change to report later
            $options_array['title'] = 'Utilization Rate by SIS'; 
            $options_array['xaxis'] = 'TTM'; 
            $options_array['yaxis'] = 'Utilization Rate'; 
            
            // TODO Move this to a simple string and feed the JS later
            $options_array['options'] = NULL;
            
            // Construct search params and store in session
        	$this->search_params['table'] = 'utilization';
        	$this->search_params['where'] = array('utilization_rate <' => 4, 'utilization_rate !=' => 0);
        	$this->search_params['sort_col'] = 'sis';
        	$this->search_params['sort_dir'] = 'ASC';
    		$this->session->set_userdata('search_params', $this->search_params);
            
			// Store the fields that will be used in the global variable.
			// They'll be used later when gathering data for the JSON call 
            $this->bubble_fields[] = array('field' => 'member_name', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'ttm', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'utilization_rate', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'sis', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'enrollment', 'type' => 'number');
            
            // The bubble_fields array will be picked up on the recursive call for the JSON 
            // post in CHART_NAME_data
    		$this->session->set_userdata('bubble_fields', $this->bubble_fields);
			
			// Load the header with the java script.
			// Will move to JS folder later
        	$this->build_bubble_page($options_array);
        }
        
        // Return a Bubble chart by platform (alpha versus delta)
        public function series_by_platform()
        {
        	$options_array = array();
        	
            // variable used for title. Will change to report later
            $options_array['title'] = 'Utilization Rate by Platform'; 
            $options_array['xaxis'] = 'TTM'; 
            $options_array['yaxis'] = 'Utilization Rate'; 
            
            // TODO move options array to here
            $options_array['options'] = NULL;
            
            // Construct search params and store in session
        	$this->search_params['table'] = 'utilization';
        	$this->search_params['where'] = array('utilization_rate <' => 4, 'utilization_rate !=' => 0);
        	$this->search_params['sort_col'] = 'service';
        	$this->search_params['sort_dir'] = 'ASC';
    		$this->session->set_userdata('search_params', $this->search_params);
			
			// Store the fields that will be used in the global variable.
			// They'll be used later when gathering data for the JSON call 
            $this->bubble_fields[] = array('field' => 'member_name', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'ttm', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'utilization_rate', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'service', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'enrollment', 'type' => 'number');
            
            // The bubble_fields array will be picked up on the recursive call for the JSON 
            // post in CHART_NAME_data
    		$this->session->set_userdata('bubble_fields', $this->bubble_fields);
    		
			// Load the header with the java script.
			// Will move to JS folder later
        	$this->build_bubble_page($options_array);
        }

        // Return a Bubble chart by Type (non grouped)
        public function series_by_type()
        {
        	// Use the CHART NAME function to set all values passed into data model. 
        	// 	This includes: Query parameters, labels, fields, types, etc
        	
        	// Clear existing SESSION data from other charts
        	$this->session->unset_userdata('search_params');
        	$this->session->unset_userdata('bubble_fields');
        	
        	// Array used for uptions.
        	$options_array = array();
        	
            // variable used for title. Will change to report later
            $options_array['title'] = 'Utilization Rate by Type (Not Grouped)'; 
            $options_array['xaxis'] = 'TTM'; 
            $options_array['yaxis'] = 'Utilization Rate'; 
            
            // TODO Move this to a simple string and feed the JS later
            $options_array['options'] = NULL;
            
            // Construct search params and store in session
        	$this->search_params['table'] = 'utilization';
        	$this->search_params['where'] = array('utilization_rate <' => 4, 'utilization_rate !=' => 0);
        	$this->search_params['sort_col'] = 'type';
        	$this->search_params['sort_dir'] = 'ASC';
    		$this->session->set_userdata('search_params', $this->search_params);
            
			// Store the fields that will be used in the global variable.
			// They'll be used later when gathering data for the JSON call 
            $this->bubble_fields[] = array('field' => 'member_name', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'ttm', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'utilization_rate', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'type', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'enrollment', 'type' => 'number');
            
            // The bubble_fields array will be picked up on the recursive call for the JSON 
            // post in CHART_NAME_data
    		$this->session->set_userdata('bubble_fields', $this->bubble_fields);
			
			// Load the header with the java script.
			// Will move to JS folder later
        	$this->build_bubble_page($options_array);        
        }
        
        // Return a Bubble chart by Type (grouped)
        public function series_by_type_grouped()
        {
        
        	// Use the CHART NAME function to set all values passed into data model. 
        	// 	This includes: Query parameters, labels, fields, types, etc
        	
        	// Clear existing SESSION data from other charts
        	$this->session->unset_userdata('search_params');
        	$this->session->unset_userdata('bubble_fields');
        	
        	// Array used for uptions.
        	$options_array = array();
        	
            // variable used for title. Will change to report later
            $options_array['title'] = 'Utilization Rate by Type (Grouped)'; 
            $options_array['xaxis'] = 'TTM'; 
            $options_array['yaxis'] = 'Utilization Rate'; 
            
            // TODO Move this to a simple string and feed the JS later
            $options_array['options'] = NULL;
            
            // Construct search params and store in session
        	$this->search_params['table'] = 'utilization';
        	$this->search_params['where'] = array('utilization_rate <' => 4, 'utilization_rate !=' => 0);
        	$this->search_params['sort_col'] = 'type';
        	$this->search_params['sort_dir'] = 'ASC';
    		$this->session->set_userdata('search_params', $this->search_params);
            
			// Store the fields that will be used in the global variable.
			// They'll be used later when gathering data for the JSON call 
            $this->bubble_fields[] = array('field' => 'member_name', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'ttm', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'utilization_rate', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'type', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'enrollment', 'type' => 'number');
            
            // The bubble_fields array will be picked up on the recursive call for the JSON 
            // post in CHART_NAME_data
    		$this->session->set_userdata('bubble_fields', $this->bubble_fields);
			
			// Load the header with the java script.
			// Will move to JS folder later
        	$this->build_bubble_page($options_array); 
        }
         
        // Build the data array to feed the chart
        // Will be difficult to move to the OO methods
    	public function series_by_type_grouped_data()
        {
        	// Construct where clause
        	$where_array = array('utilization_rate <' => 4, 'utilization_rate !=' => 0);
        	
        	// Call model to perform query
        	$result = $this->graph_model->get_data_where('utilization', $where_array, 'type', 'ASC');

        	// Build Columns
        	$cols = array(
				array('label' => 'member_name', 'type' => 'string'),
				array('label' => 'ttm', 'type' => 'number'),
				array('label' => 'utilization_rate', 'type' => 'number'),
				array('label' => 'type', 'type' => 'string'),
				array('label' => 'enrollment', 'type' => 'number')
			);

			// Build rows fro result set
			$rows = array();
			foreach ($result as $nt)
			{
				$temp = array();
				$temp[] = array('v' => $nt['member_name'], 'f' =>NULL);
				$haxis_type = null;
				switch ($nt['type'])
				{
					case 'Private for profit 2 year':
						$haxis_type = mt_rand(1,9)/10;
						break;
					case 'Private for profit 4 year or above':
						$haxis_type = mt_rand(11,19)/10;
						break;	
					case 'Private not for profit less than 2 year':
						$haxis_type = mt_rand(21,24)/10;
						break;
					case 'Private not for profit 2 year':
						$haxis_type = mt_rand(25,29)/10;
						break;
					case 'Private not for profit 4 year or above':
						$haxis_type = mt_rand(31,44)/10;
						break;
					case 'Public 2 year':
						$haxis_type = mt_rand(45,59)/10;
						break;
					case 'Public 4 year or above':
						$haxis_type = mt_rand(61,77)/10;
						break;
					case 'Administrative Unit':
						$haxis_type = mt_rand(78,79)/10;
						break;	
				}
				$temp[] = array('v' => $haxis_type, 'f' =>NULL);
				$temp[] = array('v' => $nt['utilization_rate'], 'f' =>NULL);
				$temp[] = array('v' => $nt['type'], 'f' =>NULL);
				$temp[] = array('v' => $nt['enrollment'], 'f' =>NULL);
				$rows[] = array('c' => $temp);
			}
        	
            //Call function to build bubble vis json from result set
            $data['json_data'] = $this->build_json_table($cols, $rows);
        	
        	// Load the view to POST into the ajax call
        	$this->load->view('graph/data_print', $data);
        	
        }    


        // Return a Bubble chart ulization versus graduation rate
        public function series_util_vs_grad()
        {
        	// Use the CHART NAME function to set all values passed into data model. 
        	// 	This includes: Query parameters, labels, fields, types, etc
        	
        	// Clear existing SESSION data from other charts
        	$this->session->unset_userdata('search_params');
        	$this->session->unset_userdata('bubble_fields');
        	
        	// Array used for uptions.
        	$options_array = array();
        	
            // variable used for title. Will change to report later
            $options_array['title'] = 'Utilization Rate Vs. Graduation Rate'; 
            $options_array['xaxis'] = 'Graduation Rate'; 
            $options_array['yaxis'] = 'Utilization Rate'; 
            
            // TODO Move this to a simple string and feed the JS later
            $options_array['options'] = NULL;
            
            // Construct search params and store in session
        	$this->search_params['table'] = 'utilization';
        	$this->search_params['where'] = array('utilization_rate <' => 4, 'utilization_rate !=' => 0);
        	$this->search_params['sort_col'] = 'type';
        	$this->search_params['sort_dir'] = 'ASC';
    		$this->session->set_userdata('search_params', $this->search_params);
            
			// Store the fields that will be used in the global variable.
			// They'll be used later when gathering data for the JSON call 
            $this->bubble_fields[] = array('field' => 'member_name', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'grad_rate', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'utilization_rate', 'type' => 'number');
            $this->bubble_fields[] = array('field' => 'type', 'type' => 'string');
            $this->bubble_fields[] = array('field' => 'enrollment', 'type' => 'number');
            
            // The bubble_fields array will be picked up on the recursive call for the JSON 
            // post in CHART_NAME_data
    		$this->session->set_userdata('bubble_fields', $this->bubble_fields);
			
			// Load the header with the java script.
			// Will move to JS folder later
        	$this->build_bubble_page($options_array); 
        }


        // Build Bubble/Series chart page for initial page load
        // Page inlcludes header for javascript functions
        private function build_bubble_page($options_array)
        {
        	// variable used for title. Will change to report later
            $data['title'] = $options_array['title']; 
            $data['xaxis'] = $options_array['xaxis']; 
            $data['yaxis'] = $options_array['xaxis']; 
            
            // TODO move options array to here
            $data['options'] = $options_array['options'];
			
			// Load the header with the java script.
			// Will move to JS folder later
        	$this->load->view('templates/bubble_header', $data);
        	
        	// Load the main body for the bubble/series graph
        	// TODO use google chart wrapper to define the graph
        	$this->load->view('graph/bubble', $data);
        	
        	// Load footer. Generic
        	$this->load->view('templates/bubble_footer', $data);
        }
              
                    
        // Build the data array to feed the chart
    	// will load a page that only has json array for AJAX call
    	// Data arrays are supplied from session. 
    	// Session variables for query are set on initial page load method
    	public function load_bubble_data()
        {
        	// Grab the search parameters from the SESSION and build the query 
        	$search_params = $this->session->userdata('search_params');
        	$table = $search_params['table'];
        	$where = $search_params['where'];
        	$sort_col = $search_params['sort_col'];
        	$sort_dir = $search_params['sort_dir'];
        	
        	// Call model to perform query
        	$result = $this->graph_model->get_data_where($table, $where, $sort_col, $sort_dir);
        	
            // Call function to build bubble vis data json from result set
            // Store for view
            $data['json_data'] = $this->build_bubble_data($result);
        	
        	// Load the view to POST into the ajax call
        	$this->load->view('graph/data_print', $data);
        	
        }     
        
        // Takes query results and formats into JSON array for bubble graph
        public function build_bubble_data($result)
        {
        	// Store session array containing rows used in temporary array
			$temp_data = $this->session->userdata('bubble_fields');
			
			// Build Columns by passing in an array of columns per the chart
			$cols = array();
			foreach ($temp_data as $data){
				$cols[] = array('label' => $data['field'], 'type' => $data['type']);
			}
			
			// Build Rows by passing in an array of columns per the chart and filling with
			// results from query
			$rows = array();
			foreach ($result as $nt)
			{
				$temp = array();
				foreach($temp_data as $data){
					$temp[] = array('v' => $nt[$data['field']], 'f' =>NULL);
				}
				$rows[] = array('c' => $temp);
			}
        	
            // Call function to build bubble vis json from result set
            $json_array = $this->build_json_table($cols, $rows);
        	
        	return $json_array;
        }
        
        // Builds Json table for google charts from rows and columns array
        private function build_json_table($cols, $rows)
        {
        	// TODO add error checking on input //
        	
        	// Array used to store google vis data
        	$table = array();

			// cols object used for column labels
			$table['cols'] = $cols;

			// Store rows as part of google chart array
			$table['rows'] = $rows;

			return $this->build_encode_json_num_check($table);
			//return $this->build_encode_json_pretty_debug($table);
        
        }
         
        // Used to encode array to json with format checking
        // Could be moved to helper function
        private function build_encode_json_num_check($table){
			$jsonTable = json_encode($table);
			return $jsonTable;
        }
        
        // Used to encode array to json for debug
        // Could be moved to helper function
        private function build_encode_json_pretty_debug($table){
			$jsonTable = '<pre>' . json_encode($table, JSON_PRETTY_PRINT) . '</pre>';
			return $jsonTable;
        }
        
        /*
        // Function call used to supply json strong for Ajax call
        public function data_print($json_array)
        {   
            //Send json array to page
            $data['json'] = $json_array;
        	
        	// Load the main body
        	$this->load->view('graph/data_print', $data);	
        }
        */
        
}
?>