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
 * @license    	https://github.com/korobkadima/CFormGenerator.git
 * @version    	0.1
 * @author     	Dmitriy Korobka <korobka.dima@gmail.com>
 */
class CFormGeneraor
{  
    protected $result = '';
    protected $info   = array();
    protected $data   = array();
 
	function __construct()
	{
		log_message('debug', 'CFormGeneraor library initialized.');
		
		$this->load->helper('form');
	}
	
	public function set_info($info = array() )
	{
		if(!is_array($info))
		{
			throw new Exception('Info is not array');
		}
		
		if(count($info) == 0)
		{
			throw new Exception('Info array is empty');
		}
		
		$this->info = $info;
		
		return $this;
	}
	
	public function set_data($data = array() )
	{
		if(!is_array($data))
		{
			throw new Exception('Data is not array');
		}
		
		if(count($data) == 0)
		{
			throw new Exception('Data array is empty');
		}
		
		$this->data = $data;
		
		return $this;
	}
	
	private function submit( $list = array(), $data ='' )
    {
         return form_submit('action','Submit!'); 
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
					 
				return '<iframe width="510" height="400" src="http://www.youtube.com/embed/'.$output['1'].'?fmt=22&wmode=transparent" frameborder="0" allowfullscreen wmode="transparent"></iframe>';
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
		$this->result .= form_open();
			
			foreach($this->info as $option)
			{
				$onedata = isset($this->data[$option['name']]) ? $this->data[$option['name']] : 0;
				
				switch($list['type'])
				{
					 case 'input':    $this->result .= $this->input($option, $onedata); break;
					 case 'hidden':   $this->result .= $this->hidden($option, $onedata); break;
					 case 'textarea': $this->result .= $this->textarea($option, $onedata); break;
					 case 'checkbox': $this->result .= $this->checkbox($option, $onedata); break;
					 case 'select':   $this->result .= $this->select($option, $onedata); break;
					 case 'video':    $this->result .= $this->video($option, $onedata); break;
				}
			}
			
		$this->result .= $this->submit();
			
		$this->result .= form_close();
		
		return $this->result;
		
	}
}	 
   