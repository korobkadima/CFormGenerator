<?
/**
 * CFormGenerator for Codeigniter
 *
 * A Codeigniter library
 *
 * Copyright (C) 2015 Dmitriy Korobka. 
 *
 * LICENSE
 *
 * FORMGeneraor is released with dual licensing, using the GPL v3 (license-gpl3.txt) and the MIT license (license-mit.txt).
 * You don't have to do anything special to choose one license or the other and you don't have to notify anyone which license you are using.
 * Please see the corresponding license file for details of these licenses.
 * You are free to use, modify and distribute this software, but all copyright information must remain.
 *
 * @package    	GRID
 * @copyright  	Copyright (c) 2015 through 2010, Dmitriy Korobka
 * @license    	https://github.com/korobkadima/cformgenerator
 * @version    	0.1
 * @author     	Dmitriy Korobka <korobka.dima@gmail.com>
 */
class CFormGeneraor
{  
    protected $result = '';
 
	function __construct
	{
		log_message('debug', 'CFormGeneraor library initialized.');
		
		$this->load->helper('form');
	}
	
	private function submit( $list = array(), $data ='' )
    {
         return form_submit('action','добавить/обновить'); 
    } 

	private function video( $list = array(), $data ='' )
	{
		if($data)
		{
			# for YouTube Video
			
			preg_match('/v=(.*)/s',$data,$output);
					 
			if(isset($output['1']))
			{
				$output['1'] = preg_replace('/&(.*)/si','',$output['1']);
					 
				return$ '<iframe width="510" height="400" src="http://www.youtube.com/embed/'.$output['1'].'?fmt=22&wmode=transparent" frameborder="0" allowfullscreen wmode="transparent"></iframe>';
			}
		}
	}
	
    private function input($list = array(), $data ='' )
	{			 
         $js  = isset($list['js'])  ? $list['js'] : '';
                     
		 $css = isset($list['css']) ? 'style="' . $list['css'] . '"' : '';
                    									 
         if(!$data AND isset($list['default'])) $data = $list['default'];
					 
		 return form_input($list['name'], $dan, $css . $js);
	}				  
				
	private function hidden($list = array(), $data ='' )
    {                                     
         return form_hidden($list['name'], $data);
    }      

	private function file($list = array(), $data ='')
    {
		return form_upload($list['name'], $data);
	}
   
    private function checkbox($list = array(), $data ='')
	{
        $setting = array(
            'name' => $list['name'], 
            'value' => 1, 
            'checked' => $data ? 1 : 0 
		);
                     
        return form_checkbox($setting);
     }    

	 private function textarea($list = array(), $data ='')
	 {		 
		 $value = array(
			'name'  => $list['name'], 
			'value' => $data 
		 );
                                                                                  
         return form_textarea($value);
     }         
               
     private function select($list = array(), $data ='')
	 {			
		$options = array(); 
                    
		$this->db->select('id, name');
        $query = $this->db->get($list['table']);
                         
        if($query->num_rows() > 0)    
              foreach($query->result_array() as $row)
                    $options[$row['id']] = $row['name'];
        else
              $options = array('0' => '');
                        
		return form_dropdown($list['name'], $options, $data);
    }
	
	public function generate_form($list = array(), $data = array())
	{
		if(is_array($list))
		{
			$this->result .= form_open();
			
			foreach($list as $option)
			{
				$onedata = isset($data[$option['name']]) ? $data[$option['name']] : 0;
				
				switch($list['type'])
				{
					 case 'input':    $this->result .= $this->input($option, $onedata); break
					 case 'textarea': $this->result .= $this->textarea($option, $onedata); break
					 case 'checkbox': $this->result .= $this->checkbox($option, $onedata); break
					 case 'select':   $this->result .= $this->select($option, $onedata); break
					 case 'submit':   $this->result .= $this->submit(); break
					 
					 case 'video':    $this->result .= $this->video($option, $onedata); break
				}
			}
			
			$this->result .= form_close();
		
			return $this->result;
		}
		else
		{
			return throw new Exception('The list of options must be array');
		}
	}
}	
   