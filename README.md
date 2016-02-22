<h1>CFormGenerator</h1>

Small library for simple and fast generate HTML form with CodeIgniter

<h2>Example</h2> 

require_once('CFormGenerator.php'); 

    $f = new CFormGenerator();
    	
	$list = array(
	
		array(
			'name' => 'name',
			'text' => 'Name of smt.',
			'type' => 'input'
		),
		
		array(
			'name' => 'hiddenname',
			'type' => 'hidden'
		),
		
		array(
			'name' => 'text',
			'text' => 'Description',
			'type' => 'textarea'
		),
		
		array(
			'name' => 'select',
			'text' => 'Option',
			'type' => 'select',
			'table' => 'selecttable'
		)
	);
	
	#set list of options
    $f->set_info($list);
    
	#set data from array or database result like array
	$f->set_data($data);

	#print form
    print $g->generate_form();