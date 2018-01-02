<?php
class Semi_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }

        public function isMember($mb_id)
        {
        	if(!$mb_id) return false;

        	$aMemberInfo = $this->_getMemberInfo($mb_id);

        	if( is_array($aMemberInfo) && count($aMemberInfo) > 0 )
            {
                $this->_setSession($aMemberInfo);
        		return $aMemberInfo['mb_id'];
            }

        	return false;
        }

        private function _getMemberInfo($mb_id)
        {
        	if(!$mb_id) return false;

        	$this->dev_edu = $this->load->database('dev_edu', TRUE);

            $sql = "SELECT mb_id, mb_name FROM edu_member WHERE mb_id = ?";
            $query = $this->dev_edu->query($sql, array($mb_id));
            $aMemberInfo = $query->result_array();

            if( is_array($aMemberInfo) && count($aMemberInfo)>0 )
                return $aMemberInfo[0];
            else
                return false;
        }

        private function _setSession($aMemberInfo)
        {
            $aSession = array(
                 'ss_mb_id' => $aMemberInfo['mb_id']
                ,'ss_mb_name' => $aMemberInfo['mb_name']
                ,'ss_mb_key' => '621adbd62444694afb41ec21470b990e'
                ,'private-tracking' => 'pajdyz'
            );

            $this->session->set_userdata($aSession);
        }

}