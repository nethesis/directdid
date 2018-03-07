<?php
// vim: set ai ts=4 sw=4 ft=php:
namespace FreePBX\modules;
/*
 * Class stub for BMO Module class
 * In getActionbar change "modulename" to the display value for the page
 * In getActionbar change extdisplay to align with whatever variable you use to decide if the page is in edit mode.
 *
 */

class Directdid implements \BMO
{

	// Note that the default Constructor comes from BMO/Self_Helper.
	// You may override it here if you wish. By default every BMO
	// object, when created, is handed the FreePBX Singleton object.

	// Do not use these functions to reference a function that may not
	// exist yet - for example, if you add 'testFunction', it may not
	// be visibile in here, as the PREVIOUS Class may already be loaded.
	//
	// Use install.php or uninstall.php instead, which guarantee a new
	// instance of this object.
	public function install()
	{
	}
	public function uninstall()
	{
	}

	// The following two stubs are planned for implementation in FreePBX 15.
	public function backup()
	{
	}
	public function restore($backup)
	{
	}

	// http://wiki.freepbx.org/display/FOP/BMO+Hooks#BMOHooks-HTTPHooks(ConfigPageInits)
	//
	// This handles any data passed to this module before the page is rendered.
	public function doConfigPageInit($page) {
		$id = $_REQUEST['id']?$_REQUEST['id']:'';
		$action = $_REQUEST['action']?$_REQUEST['action']:'';
		$exampleField = $_REQUEST['example-field']?$_REQUEST['example-field']:'';
		//Handle form submissions
		switch ($action) {
		case 'add':
			$id = $this->addItem($exampleField,$body);
			$_REQUEST['id'] = $id;
			break;
		case 'edit':
			$this->updateItem($id,$exampleField,$body);
			break;
		case 'delete':
			$this->deleteItem($id);
			unset($_REQUEST['action']);
			unset($_REQUEST['id']);
			break;
		}
	}

	// http://wiki.freepbx.org/pages/viewpage.action?pageId=29753755
	public function getActionBar($request)
	{
		$buttons = array();
		switch ($request['display']) {
		case 'directdid':
			$buttons = array(
				/*'delete' => array(
					'name' => 'delete',
					'id' => 'delete',
					'value' => _('Delete')
				),
				'reset' => array(
					'name' => 'reset',
					'id' => 'reset',
					'value' => _('Reset')
				),*/
				'submit' => array(
					'name' => 'submit',
					'id' => 'submit',
					'value' => _('Submit')
				)
			);
			if (empty($request['extdisplay'])) {
				unset($buttons['delete']);
			}
			break;
		}
		return $buttons;
	}

	// http://wiki.freepbx.org/display/FOP/BMO+Ajax+Calls
	public function ajaxRequest($req, &$setting)
	{
		switch ($req) {
		case 'getJSON':
			return true;
			break;
		default:
			return false;
			break;
		}
	}

	// This is also documented at http://wiki.freepbx.org/display/FOP/BMO+Ajax+Calls
	public function ajaxHandler()
	{
		switch ($_REQUEST['command']) {
		case 'getJSON':
			switch ($_REQUEST['jdata']) {
			case 'grid':
				$ret = array();
				/*code here to generate array*/
				return $ret;
				break;

			default:
				return false;
				break;
			}
			break;

		default:
			return false;
			break;
		}
	}

	// http://wiki.freepbx.org/display/FOP/Adding+Floating+Right+Nav+to+Your+Module
	public function getRightNav($request)
	{
		$html = '<p>Custom HTML</p>';
		return $html;
	}

	// http://wiki.freepbx.org/display/FOP/HTML+Output+from+BMO
	public function showPage()
	{
		switch ($_REQUEST['view']) {
		case 'form':
			if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
				$subhead = _('Edit Direct DID');
				$content = load_view(__DIR__.'/views/form.php', $this->getOne($_REQUEST['id']));
			}else{
				$subhead = _('Add Direct DID');
				$content = load_view(__DIR__.'/views/form.php');
			}
			break;
		default:
			$subhead = _('Direct DID List');
			$content = load_view(__DIR__.'/views/grid.php');
			break;
		}
		echo load_view(__DIR__.'/views/default.php', array('subhead' => $subhead, 'content' => $content));
	}

	/**
	 * Below are examples of how to use FreePBX's kvstore.
	 *
	 * DB_Helper is available when you 'implements \BMO' in the Class Definition.
	 * For more documentation, see http://wiki.freepbx.org/display/FOP/BMO+DB_Helper
	 */
	public function getOne($id){
		return $this->getConfig($id, "settingsgroup");
	}
	/**
	 * getList gets a list od subjects and their respective id.
	 */
	public function getList(){
		return $this->getAll("settingsgroup");
	}
	/**
	 * addItem Add an Item
	 */
	public function addItem($data){
		$this->setConfig($data['subject'], $data['body'], 'items');
	}
	/**
	 * updateItem Updates the given ID
	 */
	public function updateItem($id,$data){
		$this->addItem(array("subject" => $id, "data" => $data));
	}
	/**
	 * deleteItem Deletes the given ID
	 */
	public function deleteItem($id){
		// Setting an item to (bool) 'false' deletes it from the kvstore.
		$this->addItem(array("subject" => $id, "data" => false));
	}
}
