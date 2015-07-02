<?php
class Graph_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        
        // Returns an entire data set from a table without and delimiters
      	public function get_data_full()
		{
			$query = $this->db->get('utilization');
			return $query->result_array();
		}
			
		// Allows Controller to send in a defined query
		public function get_data_string($query)
		{
			if ($query === NULL)
				return "error";
			
			$query = $this->db->query($query);
        	return $query->result_array();
				
		}	
		
		// Allows contorller to specify a table and a where clause
		public function get_data_where($table, $where =  NULL, $order = NULL, $sort = NULL)
		{
			if ($table === NULL)
				return "error";
			
			$query = $this->db->order_by($order, $sort)->get_where($table, $where);
        	return $query->result_array();
				
		}			
}
