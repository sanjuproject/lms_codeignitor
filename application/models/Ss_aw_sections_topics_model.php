<?php

/**
 * 
 */
class Ss_aw_sections_topics_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_sections_topics";
	}
	public function get_topiclist_bylevel($level)
	{
		$where = "FIND_IN_SET('" . $level . "', ss_aw_expertise_level)";
		return $this->db->where($where)->order_by('ss_aw_section_id', 'ASC')->get($this->table)->result_array();
	}

	public function fetchall()
	{
		return $this->db->get($this->table)->result_array();
	}

	public function number_of_records($search_data = array())
	{
		if (isset($search_data['ss_aw_expertise_level'])) {
			$level = $search_data['ss_aw_expertise_level'];
			$where = "FIND_IN_SET('" . $level . "', ss_aw_expertise_level)";
			$this->db->where($where);
			unset($search_data['ss_aw_expertise_level']);
		}
		if (!empty($search_data)) {
			foreach ($search_data as $key => $value) {
				$this->db->Like('`' . $this->table . '.' . '`' . $key . '`', $value, 'both');
			}
		}
		$this->db->where('ss_aw_topic_deleted', '1');
		return $this->db->get($this->table)->num_rows();
	}
	public function get_all_records($limit = 0, $start = 0, $search_data = array())
	{
		if (isset($search_data['ss_aw_expertise_level'])) {
			if ($search_data['ss_aw_expertise_level'] != "") {
				$expertise_level = explode(",", $search_data['ss_aw_expertise_level']);
				if (!empty($expertise_level)) {
					$where = "";
					foreach ($expertise_level as $i => $level) {
						if ($i == 0) {
							$where .= "FIND_IN_SET('" . $level . "', ss_aw_expertise_level)";
						} else {
							$where .= "OR FIND_IN_SET('" . $level . "', ss_aw_expertise_level)";
						}
					}
					$this->db->where($where);
				}
				unset($search_data['ss_aw_expertise_level']);
			}
		}
		$this->db->select($this->table . '.*');
		if (!empty($search_data)) {
			foreach ($search_data as $key => $value) {
				$this->db->Like('`' . $this->table . '.' . '`' . $key . '`', $value, 'both');
			}
		}
		if (!empty($limit)) {
			$this->db->limit($limit, $start);
		}
		$this->db->where($this->table . '.ss_aw_topic_deleted', '1');
		//$this->db->where($this->table . '.ss_aw_section_status', '1');
		$this->db->order_by('ss_aw_section_reference_no', 'ASC');
		return $this->db->get($this->table)->result();
	}
	public function add_data($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function number_of_topicrecords($section_name, $status_check)
	{
		if ($section_name != "") {
			$this->db->like('ss_aw_section_title', $section_name);
		}
		if ($status_check != "") {
			$this->db->where('ss_aw_section_status', $status_check);
		}
		$this->db->where('ss_aw_topic_deleted', '1');

		return $this->db->get($this->table)->num_rows();
	}

	public function get_all_topicrecords($limit, $start, $section_name, $status_check)
	{

		if ($section_name != "") {

			$this->db->like('ss_aw_section_title', $section_name);
		}
		if ($status_check != "") {
			$this->db->where('ss_aw_section_status', $status_check);
		}
		$this->db->where('ss_aw_topic_deleted', '1');
		$this->db->order_by('ss_aw_section_title', 'ASC');
		$this->db->limit($limit, $start);
		return $this->db->get($this->table)->result();
	}
	public function update_topic_data($topic_id, $update_data)
	{

		$this->db->where('ss_aw_section_id', $topic_id)->update($this->table, $update_data);
	}

	public function update_record($param)
	{
		foreach ($param as $key => $value) {
			if ($key != 'ss_aw_topic_deleted' && $key != 'status' && $key != 'ss_aw_section_status' && $key != 'ss_aw_section_title' && $key != 'status')
				$this->db->where("`" . $key . "`", $value);
		}

		if (!empty($param['ss_aw_topic_deleted'])) {
			$this->db->set('ss_aw_topic_deleted', 0);
		} else if (!empty($param['status'])) {
			$this->db->set('ss_aw_section_status', $param['ss_aw_section_status']);
		}
		$this->db->update($this->table, $param);
	}

	public function fetch_record_byparam($search_data = array())
	{
		if (!empty($search_data)) {
			foreach ($search_data as $key => $value) {
				$this->db->Like('`' . $this->table . '.' . '`' . $key . '`', $value);
			}
		}
		$this->db->where('ss_aw_topic_deleted', '1');
		return $this->db->get($this->table)->result_array();
	}

	public function getrecordbyid($topic_id)
	{
		$this->db->where('ss_aw_section_id', $topic_id);
		return $this->db->get($this->table)->result();
	}

	public function gettopicdetailbyreferenceno($reference)
	{
		$this->db->where('ss_aw_section_reference_no', $reference);
		return $this->db->get($this->table)->result();
	}

	public function getalltopic()
	{
		$this->db->where('ss_aw_section_status', 1);
		$this->db->where('ss_aw_topic_deleted', 1);
		return $this->db->get($this->table)->result();
	}

	public function get_topiccount_bylevel($level)
	{
		$where = "FIND_IN_SET('" . $level . "', ss_aw_expertise_level)";
		return $this->db->where($where)->where('ss_aw_section_status', 1)->where('ss_aw_topic_deleted', 1)->order_by('ss_aw_section_id', 'ASC')->get($this->table)->num_rows();
	}

	public function get_last_record()
	{
		$this->db->limit(1);
		$this->db->order_by('ss_aw_section_id', 'desc');
		return $this->db->get($this->table)->row();
	}

	public function get_question_store_rules($topic_id)
	{
		$this->db->select('st.ss_aw_section_id,st.ss_aw_section_title, COUNT(ss.ss_aw_subtopic_id) cnt_sub_section,'
			. 'sm.ss_aw_total_question');
		$this->db->from("ss_aw_sections_topics st");
		$this->db->join("ss_aw_sections_subtopics ss", "ss.ss_aw_topic_id = st.ss_aw_section_id
        AND ss.ss_aw_section_status = '1'
        AND ss.ss_aw_subtopic_deleted = '1'");
		$this->db->join("ss_aw_assessment_subsection_matrix sm", "sm.ss_aw_sub_section_no=(select COUNT(ss_aw_subtopic_id) from  ss_aw_sections_subtopics where ss_aw_topic_id = ss_aw_section_id
        AND ss.ss_aw_section_status = '1'
        AND ss_aw_subtopic_deleted = '1' group by ss_aw_topic_id)");
		$this->db->where("st.ss_aw_section_id", $topic_id);
		$this->db->group_by("st.ss_aw_section_id");
		return $this->db->get()->row();
	}
}
