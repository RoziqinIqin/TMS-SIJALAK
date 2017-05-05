<?php
class Form_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  function getform($fname) {
    $gf = $this->db->query("select t0.*,t1.fld_tblnm,t1.fld_tblpkey  from tbl_form t0
    left join tbl_tbl t1 on t1.fld_tblid=t0.fld_tblid
    where t0.fld_formnm = '$fname'");
    if ($gf->num_rows() > 0) {
      $row = $gf->row();
      return $row;
    }
  }

  function getformbyID($fid) {
    $gf = $this->db->query("select t0.*,t1.fld_tblnm,t1.fld_tblpkey  from tbl_form t0
    left join tbl_tbl t1 on t1.fld_tblid=t0.fld_tblid
    where t0.fld_formid = '$fid'");
    if ($gf->num_rows() > 0) {
      $row = $gf->row();
      return $row;
    }
  }

  function getformfield($fld_formid) {
    $gff = $this->db->query("select t0.*,t1.fld_querysql,t1.fld_queryid,t1.fld_querynm  from tbl_formfield t0
    left join tbl_query t1 on t1.fld_queryid=t0.fld_queryid
    where t0.fld_formid = '$fld_formid'  order by t0.fld_formfieldorder");
    if ($gff->num_rows() > 0) {
      return $gff->result();
    }
  }

  function getformfieldbyName($fld_formnm) {
    $gff = $this->db->query("select t0.*,t1.fld_querysql,t1.fld_queryid,t1.fld_querynm  from tbl_formfield t0
    left join tbl_query t1 on t1.fld_queryid=t0.fld_queryid
    left join tbl_form t2 on t2.fld_formid=t0.fld_formid
    where t2.fld_formnm = '$fld_formnm'  order by t0.fld_formfieldorder");
    if ($gff->num_rows() > 0) {
      return $gff->result();
    }
  }

  function getsubform($fld_formid) {
    $gsf = $this->db->query("select t1.fld_formid,t1.fld_formlbl,t1.fld_formtmpl,t3.fld_querysql,
    t1.fld_formnm,t0.fld_formrelp,t0.fld_formrelc,t4.fld_tblnm,t4.fld_tblpkey,
    t0.fld_subformshow,t0.fld_subformty,t3.fld_queryid,t2.fld_viewnm,t0.fld_subformfu,
    t1.fld_formcreate,t1.fld_formdelete
    from tbl_subform t0
    left join tbl_form t1 on t1.fld_formid=t0.fld_formidc
    left join tbl_view t2 on t2.fld_viewnm = t1.fld_formnm
    left join tbl_query t3 on t3.fld_queryid=t2.fld_queryid
    left join tbl_tbl t4 on t4.fld_tblid=t1.fld_tblid
    where t0.fld_formidp = '$fld_formid' order by t0.fld_subformord");
    if ($gsf->num_rows() > 0) {
      return $gsf->result();
    }
  }

  function getformview($fld_formid) {
    $gsf = $this->db->query("select t1.fld_formid,t0.fld_formviewnm,t3.fld_querysql,t3.fld_queryid,t1.fld_formnm,t4.fld_tblnm,t4.fld_tblpkey,t0.fld_formrelid,
    t0.fld_viewrelid,t2.fld_viewtmpl,t2.fld_viewcreate,t2.fld_viewnm,fld_viewupdate,fld_viewdelete  from tbl_formview t0
    left join tbl_form t1 on t1.fld_formid=t0.fld_formid
    left join tbl_view t2 on t2.fld_viewid = t0.fld_viewid
    left join tbl_query t3 on t3.fld_queryid=t2.fld_queryid
    left join tbl_tbl t4 on t4.fld_tblid=t1.fld_tblid
    where t0.fld_formid = '$fld_formid' order by t0.fld_formvieword");
    if ($gsf->num_rows() > 0) {
      return $gsf->result();
    }
  }

  function getdefsubform($fld_formid) {
    $gsf = $this->db->query("select * from (select t1.fld_formlbl AS 'label' , t0.fld_subformord AS 'orderdef'  from tbl_subform t0
	left join tbl_form t1 on t1.fld_formid=t0.fld_formidc
	where t0.fld_formidp = '$fld_formid' and t0.fld_subformshow=1
	union
	select t0.fld_formviewnm AS 'label' , t0.fld_formvieword AS 'orderdef' from tbl_formview t0
	where t0.fld_formid = '$fld_formid') tz0 order by orderdef limit 1 ");
	if ($gsf->num_rows() > 0) {
	  foreach ($gsf->result() as $row) {
	    return $row->label;
	  }
	}
  }
	
  function getformfieldval($tabelnm,$pkey,$node) {
    $gffval = $this->db->query("select *  from $tabelnm where $pkey='$node' limit 1");
    if ($gffval->num_rows() > 0) {
      return $gffval->result();
    }
  }

  function getformupdate($tabelnm,$pkey,$data,$pkeyval) {
    $this->db->where($pkey, $pkeyval);
    $this->db->update($tabelnm, $data);
    $this->db->limit(1);
    return $this->db->affected_rows();
  }

	function getformcopy($tabelnm,$data)
	    {
		$this->db->insert($tabelnm, $data);
		$this->db->limit(1);
		return $this->db->affected_rows();
	    }

	function getforminsert($tabelnm,$data)
	    {
		$this->db->insert($tabelnm, $data);
		$this->db->limit(1);
		return $this->db->affected_rows();
	    }

	function getformreplace($tabelnm,$data)
	    {
		$this->db->replace_into($tabelnm, $data);
		$this->db->limit(1);
		return $this->db->affected_rows();
	    }

	function getautonumber()
	    {
		$query = $this->db->query("select no_license from tbl_license order by id_license desc limit 1");

		   foreach ($query->result() as $row)
			{

			}

		$get_seq_number = (substr($row->no_license,2,4)+1);
		$seq_number = str_pad($get_seq_number, 4, "0", STR_PAD_LEFT);
		$no_license = "PG" . $seq_number;

		return $no_license;

	    }

  function getfollowup($node,$groupid) {
    $gsf = $this->db->query("select t2.fld_bttynm,t2.fld_bttyid,t0.fld_btid,t2.fld_bttyform,t3.fld_formid 'nextformid',(select count(1) 
	from tbl_btr tx0 
	left join tbl_bth tx1 on tx1.fld_btid=tx0.fld_btrdst 
	where 
	tx0.fld_btrsrc=t0.fld_btid 
	and 
	tx1.fld_bttyid=t2.fld_bttyid) 'fld_count',t1.fld_workflowmax 
    from tbl_bth t0 
    inner join tbl_workflow t1 on t1.fld_workflowsrc=t0.fld_bttyid  
    left join tbl_btty t2 on t2.fld_bttyid=t1.fld_workflowdst 
    left join tbl_form t3 on t3.fld_formnm = t2.fld_bttyform  
    left join tbl_transaprv t4 on t4.fld_bttyid=t2.fld_bttyid
    left join tbl_aprvrule t5 on t5.fld_aprvruleid=t4.fld_aprvruleid
    where
    t0.fld_btid=$node 
    and 
    t0.fld_btstat >= t1.fld_workflowtoa
    and
    t5.fld_usergrpid=$groupid 
    ");
	if ($gsf->num_rows() > 0) {
	  return $gsf->result();
	}
  }

	function getdatafup($btid)
	    {
		$gsf = $this->db->query("select * from tbl_bth where fld_btid=$btid");
		if ($gsf->num_rows() > 0)
		{
		return $gsf->result_array();
		}
	    }

	function getPrintLink($fid)
	    {
 		$gsf = $this->db->query("select t0.fld_formprintnm,t0.fld_formprinturl,t0.fld_formprintsts from tbl_formprint t0 where fld_formid=$fid");
 		if ($gsf->num_rows() > 0)
 		{
 		return $gsf->result();
 		}
	    }

        function getTransMap($btid) {
                $gsf = $this->db->query("select t1.fld_btno,t2.fld_bttyform,t1.fld_btid, concat('up') 'level' from tbl_btr t0 
                left join tbl_bth t1 on t1.fld_btid=t0.fld_btrsrc
                left join tbl_btty t2 on t2.fld_bttyid=t1.fld_bttyid 
                where t0.fld_btrdst=$btid
                UNION
                select t1.fld_btno,t2.fld_bttyform,t1.fld_btid, concat('down') 'level' from tbl_btr t0 
                left join tbl_bth t1 on t1.fld_btid=t0.fld_btrdst
                left join tbl_btty t2 on t2.fld_bttyid=t1.fld_bttyid 
                where t0.fld_btrsrc=$btid");
                if ($gsf->num_rows() > 0)
                {
                return $gsf->result();
                }
        }


	function getdatafupsub($relc,$relp,$btid,$tbl_name)
	    {
		$gsf = $this->db->query("select * from $tbl_name where $relc=$btid");
		if ($gsf->num_rows() > 0)
		{
		return $gsf->result_array();
		}
	    }

  function getApprovalRule($btid) {
   $gf = $this->db->query("select t1.fld_bttyrule from tbl_bth t0 left join tbl_btty t1 on t1.fld_bttyid=t0.fld_bttyid where t0.fld_btid=$btid");
   if ($gf->num_rows() > 0) {
     $row = $gf->row();
     return $row;
   }
 }

  function getApprovalRole($btid,$groupid) {
    $gf = $this->db->query("select t4.fld_aprvroleid
                               from tbl_bth t0 
                               left join tbl_btty t1 on t1.fld_bttyid=t0.fld_bttyid
                               left join tbl_transaprv t2 on t2.fld_bttyid=t1.fld_bttyid
                               left join tbl_aprvrule t3 on t3.fld_aprvruleid=t2.fld_aprvruleid
							   left join tbl_aprvrulerole t4 on t4.fld_aprvruleid=t3.fld_aprvruleid
                               where t0.fld_btid=$btid and t4.fld_usergrpid=$groupid ");
    foreach ($gf->result() as $row) {
      return $row->fld_aprvroleid;
    }
  }

  function getApprovalInisiator($btid,$groupid) {
    $gf = $this->db->query("select t3.fld_usergrpid
                               from tbl_bth t0 
                               left join tbl_btty t1 on t1.fld_bttyid=t0.fld_bttyid
                               left join tbl_transaprv t2 on t2.fld_bttyid=t1.fld_bttyid
                               left join tbl_aprvrule t3 on t3.fld_aprvruleid=t2.fld_aprvruleid
                               where t0.fld_btid=$btid and  t3.fld_usergrpid = $groupid");
  
    if ($gf->num_rows() > 0) {
      $request_aprv = 1;
    }
    else {
      $request_aprv = 0;
    }
    return $request_aprv;
  }

	function getApprovalStatus($btid) {
		$gf = $this->db->query("select t0.fld_btstat from tbl_bth t0 where t0.fld_btid=$btid");
		if ($gf->num_rows() > 0) {
		  $row = $gf->row();
		  return $row;
		}
	    }
}
