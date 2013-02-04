<?php

namespace Core\Controller;

/**
 * Admin Controller
 * @author Evan Byrne
 */
class Admin extends Base {
	
	/**
	 * array Which models are editable via admin
	 */
	public static $models = array('user');

	/**
	 * boolean Use HTTPS
	 */
	public static $https = false;

	/**
	 * Get Columns
	 * @param \Core\Modle\Base
	 * @param string Name of option to check for value of bool(true)
	 * @return array Array of columns in this format: array(name => options, ...)
	 */
	protected function get_columns($model, $option = null) {

		$columns = array();
		foreach($model->get_admin() as $column_name => $options) {

			if($option !== null) {

				if($options[$option]) {

					$columns[$column_name] = $options;

				}

			} else {

				$columns[$column_name] = $options;

			}

		}

		return $columns;

	}

	/**
	 * Get Rows
	 * @param string Model name
	 * @param array Columns names
	 * @param \Mysql\Select Custom select query
	 */
	protected function get_rows($model_name, $columns, $select = null, $page = 1) {

		$model_class = "\\Model\\$model_name";
		$model = new $model_class();
		$select = ($select === null) ? $model_class::select()->page($page, ADMIN_PAGE_SIZE)->order_desc('id') : $select;
		$belongsto = array();
		$choices = array();

		foreach($columns as $column_name => $options) {

			$column = $model->get_schema_column($column_name);

			// Columns with defined static choices
			if(is_array($column->get_option('choices'))) {

				$choices[$column_name] = $column->get_option('choices');

			}

			// BelongsTo columns
			if(is_a($column, '\\Column\\BelongsTo')) {

				$belongsto[$column_name] = $column;

			}

		}

		// Fetch rows
		$rows = $select->fetch();
		$row_count = count($rows);

		// Build columns with choices
		if(!empty($choices)) {

			for($i = 0; $i < $row_count; $i++) {

				foreach($choices as $column_name => $c) {

					$rows[$i]->{$column_name} = $c[$rows[$i]->{$column_name}];

				}

			}

		}

		// Build BelongsTo column query
		if(!empty($belongsto)) {

			foreach($belongsto as $column_name => $column) {

				$belongsto_class = '\\Model\\' . $column_name;
				$belongsto_select = $belongsto_class::select();
				$values = array();

				// Get unique values for column
				foreach($rows as $row) {

					$id = $row->{$column_name};
					if(!in_array($id, $values)) {

						if(empty($values)) {
						
							$belongsto_select->where('id', '=', $id);

						} else {

							$belongsto_select->or_where('id', '=', $id);							

						}

						$values[] = $id;

					}

				}

				// Query the database
				$tmp = $belongsto_select->fetch();
				$belongsto_results = array();
				foreach($tmp as $res) {

					$belongsto_results[$res->id] = $res;

				}

				for($i = 0; $i < $row_count; $i++) {

					$id = $rows[$i]->{$column_name};
					$rows[$i]->{$column_name} = $belongsto_results[$id];

				}

			}

		}

		return $rows;

	}

	/**
	 * Construct
	 */
	public function __construct() {
		
		Auth\Standard::enforce('admin');
		
	}
	
	/**
	 * Index
	 */
	public function index() {
		
		$models = array();
		foreach(static::$models as $model) {
			
			$model_class = "\\Model\\$model";
			$models[$model] = array(
				'name'        => $model_class::get_verbose(),
				'name_plural' => $model_class::get_verbose_plural()
			);
			
		}
		
		$this->data('models', $models);
	
	}
	
	/**
	 * Model
	 * @param string Model
	 */
	public function model($name, $select = null) {
		
		// 404 on unconfigured model
		if(!in_array($name, static::$models)) {

			$this->error(404);

		}

		$model_class = "\\Model\\$name";
		$model = new $model_class();
		$columns = $this->get_columns($model, 'list');
		$total_rows = $model_class::select()->count_column('id', 'total')->single();
		$page = \Library\Input::get('page', 1);
		$page_count = ceil(intval($total_rows->total) / ADMIN_PAGE_SIZE);

		$this->data('columns', $columns);
		$this->data('rows', $this->get_rows($name, $columns, $select, $page));
		$this->data('model', $name);
		$this->data('model_name', $model_class::get_verbose());

		$url = route_url('get', 'admin', 'model', array($name)) . '&page=';
		$this->data('next', ($page < $page_count) ?  $url . ($page + 1) : null);
		$this->data('prev', ($page > 1) ? $url . ($page - 1) : null);

		if(file_exists(APPLICATION . "/template/admin/$name/model.php")) {

			$this->template("admin/$name/model");

		}
		
	}
	
	/**
	 * Children
	 * @param string Parent model
	 * @param string Parent row ID
	 * @param string Model
	 */
	public function children($parent_model, $parent_id, $child_model) {

		$model_class = "\\Model\\$child_model";
		$model = new $model_class();

		$total_rows = $model_class::select()->where($parent_model, '=', $parent_id)->count_column('id', 'total')->single();
		$page = \Library\Input::get('page', 1);
		$page_count = ceil(intval($total_rows->total) / ADMIN_PAGE_SIZE);
		$select = $model_class::select()->where($parent_model, '=', $parent_id)->page($page, ADMIN_PAGE_SIZE)->order_desc('id');
		$this->model($child_model, $select);

		$url = route_url('get', 'admin', 'children', array($parent_model, $parent_id, $child_model)) . '&page=';
		$this->data('next', ($page < $page_count) ?  $url . ($page + 1) : null);
		$this->data('prev', ($page > 1) ? $url . ($page - 1) : null);

		$parent_model_class = '\\Model\\' . $parent_model;
		$this->data(array(
			
			'parent_model' => $parent_model,
			'parent_id'    => $parent_id,
			'parent_name'  => $parent_model_class::get_verbose(),
			'child_model'  => $child_model
			
		));

		if(file_exists(APPLICATION . "/template/admin/$parent_model/children-$child_model.php")) {

			$this->template("admin/$parent_model/children-$child_model");

		} elseif(file_exists(APPLICATION . "/template/admin/$parent_model/children.php")) {

			$this->template("admin/$parent_model/children");

		} else {

			$this->template('admin/children');

		}
		
	}

	/**
	 * Edit
	 * @param string Model
	 * @param string Row ID
	 * @param string Redirect URL
	 */
	public function edit($model, $id, $redirect = null) {

		// 404 on unconfigured model
		if(!in_array($model, static::$models)) {

			$this->error(404);

		}

		$model_class = "\\Model\\$model";
		$row = $model_class::id($id) or $this->error(404);
		
		$schema = $row->get_schema();
		$admin = $row->get_admin();
		$columns = array();
		$is_multipart = false;
		$inlines = array();

		foreach($schema as $column) {
		
			$name = $column->column_name();
			if(isset($admin[$name])) {
				
				if(is_a($column, '\\Column\\HasMany')) {
				
					$child_model_class = '\\Model\\' . $column->get_option('model');
					$parent_column = $column->get_option('column');
					$child_model = new $child_model_class();
					$child_select = $child_model_class::select()->where($parent_column, '=', $id)->order_asc('id');
					$child_columns = $this->get_columns($child_model, 'list');
					unset($child_columns[$parent_column]);

					$inlines[$child_model->table()] = array(
						'verbose' => $child_model_class::get_verbose(),
						'verbose_plural' => $child_model_class::get_verbose_plural(),
						'rows' => $this->get_rows($column->get_option('model'), $child_columns, $child_select),
						'columns' => $child_columns
					);
				
				} elseif(is_a($column, '\\Column\\ManyToMany')) {

					$child_model_class = '\\Model\\' . $column->get_option('middleman');
					$parent_column = $model_class::table();
					$child_model = new $child_model_class();
					$child_select = $child_model_class::select()->where($parent_column, '=', $id)->order_asc('id');
					$child_columns = $this->get_columns($child_model, 'list');
					unset($child_columns[$parent_column]);

					$inlines[$child_model->table()] = array(
						'verbose' => $child_model_class::get_verbose(),
						'verbose_plural' => $child_model_class::get_verbose_plural(),
						'rows' => $this->get_rows($column->get_option('middleman'), $child_columns, $child_select),
						'columns' => $child_columns
					);

				} else {
				
					// All other columns
					$columns[$name] = array('options' => array_merge($column->options(), $admin[$name]));
					$columns[$name]['value'] = (isset($row->{$name})) ? $row->{$name} : null;
					
					// BelongsTo columns
					if(is_a($column, '\\Column\\BelongsTo')) {
						
						$column_model_class = "\\Model\\$name";
						$choices = array();
						
						foreach($column_model_class::select()->order_desc('id')->fetch() as $r) {
							
							$choices[$r->id] = $r;
							
						}
						
						$columns[$name]['options']['choices'] = $choices;
						$columns[$name]['options']['template'] = 'select';
						
					} elseif(is_a($column, '\\Column\\File')) {

						$is_multipart = true;

					}

				}

			}

		}

		if(is_post()) {

			$row->merge_post(array_keys($columns), $is_multipart);
			
			if($this->valid($row)) {

				$row->save();
				redirect(($redirect === null) ? "admin/$model" : $redirect, static::$https);

			} else {

				foreach($columns as $name => $value) {
					
					$columns[$name]['value'] = $row->{$name};

				}

			}

		}

		$this->data('model', $model);
		$this->data('model_name', $model_class::get_verbose());
		$this->data('row', $row);
		$this->data('columns', $columns);
		$this->data('is_multipart', $is_multipart);
		$this->data('inlines', $inlines);

		if(file_exists(APPLICATION . "/template/admin/$model/edit.php")) {

			$this->template("admin/$model/edit");

		}

	}
	
	/**
	 * Edit Child
	 * @param string Parent model
	 * @param string Parent row ID
	 * @param string Child model
	 * @param string Child row ID
	 */
	public function edit_child($parent_model, $parent_id, $child_model, $child_id) {
		
		$parent_model_class = "\\Model\\$parent_model";
		$parent = $parent_model_class::id($parent_id) or $this->error(404);
		
		$this->edit($child_model, $child_id, "admin/$parent_model/$parent_id");

		$parent_model_class = '\\Model\\' . $parent_model;
		$this->data(array(
			
			'parent'       => $parent,
			'parent_model' => $parent_model,
			'parent_name'  => $parent_model_class::get_verbose(),
			'parent_id'    => $parent_id
		
		));

		if(file_exists(APPLICATION . "/template/admin/$parent_model/edit_child-$child_model.php")) {

			$this->template("admin/$parent_model/edit_child-$child_model");

		} elseif(file_exists(APPLICATION . "/template/admin/$parent_model/edit_child.php")) {

			$this->template("admin/$parent_model/edit_child");

		} else {

			$this->template('admin/edit_child');

		}
		
	}

	/**
	 * Delete
	 * @param string Model
	 * @param string Row ID
	 */
	public function delete($model, $id) {

		// 404 on unconfigured model
		if(!in_array($model, static::$models)) {

			$this->error(404);

		}

		$model_class = "\\Model\\$model";
		$row = $model_class::id($id) or $this->error(404);

		if(is_post()) {

			$model_class::delete()->where('id', '=', $id)->limit(1)->execute();
			redirect("admin/$model", static::$https);

		} else {

			$this->data('model', $model);
			$this->data('model_name', $model_class::get_verbose());
			$this->data('id', $id);

		}

		if(file_exists(APPLICATION . "/template/admin/$model/delete.php")) {

			$this->template("admin/$model/delete");

		}

	}

	/**
	 * Add
	 * @param string Model
	 * @param string Redirect URL
	 */
	public function add($model, $redirect = null) {

		// 404 on unconfigured model
		if(!in_array($model, static::$models)) {

			$this->error(404);

		}

		$model_class = "\\Model\\$model";
		$row = new $model_class();
		
		$schema = $row->get_schema();
		$admin = $row->get_admin();
		$columns = array();
		$children = array();
		$is_multipart = false;

		foreach($schema as $column) {
		
			$name = $column->column_name();
			if(isset($admin[$name])) {
				
				if(is_a($column, '\\Column\\HasMany')) {
				
					// HasMany columns
					$children[$column->column_name()] = strtolower($column->get_option('model'));
				
				} elseif(!is_a($column, '\\Column\\ManyToMany')) {
				
					// All other columns
					$columns[$name] = array(
						
						'options' => array_merge($column->options(), $admin[$name]),
						'value'   => null
					
					);
					
					if(is_a($column, '\\Column\\BelongsTo')) {
						
						// BelongsTo columns
						$column_model_class = "\\Model\\$name";
						$choices = array();
						
						foreach($column_model_class::select()->order_desc('id')->fetch() as $r) {
							
							$choices[$r->id] = $r;
							
						}
						
						$columns[$name]['options']['choices'] = $choices;
						$columns[$name]['options']['template'] = 'select';
						
					} elseif(is_a($column, '\\Column\\File')) {
						
						$is_multipart = true;
						
					}

				}

			}

		}

		if(is_post()) {

			$row = $model_class::from_post(array_keys($columns), $is_multipart);
			
			if($this->valid($row)) {

				$id = $row->save();
				redirect(($redirect === null) ? "admin/$model" : $redirect, static::$https);

			} else {

				foreach($columns as $name => $value) {
					
					$columns[$name]['value'] = $row->{$name};

				}

			}

		}
		
		$this->data('model', $model);
		$this->data('model_name', $model_class::get_verbose());
		$this->data('row', $row);
		$this->data('columns', $columns);
		$this->data('children', $children);
		$this->data('is_multipart', $is_multipart);

		if(file_exists(APPLICATION . "/template/admin/$model/add.php")) {

			$this->template("admin/$model/add");

		}

	}
	
	/**
	 * Add Child
	 * @param string Parent model
	 * @param string Parent row ID
	 * @param string Child model
	 */
	public function add_child($parent_model, $parent_id, $child_model) {
		
		$parent_model_class = "\\Model\\$parent_model";
		$parent = $parent_model_class::id($parent_id) or $this->error(404);
		
		$this->add($child_model, "admin/$parent_model/$parent_id");

		$parent_model_class = '\\Model\\' . $parent_model;
		$this->data(array(
			
			'parent'       => $parent,
			'parent_model' => $parent_model,
			'parent_name'  => $parent_model_class::get_verbose(),
			'parent_id'    => $parent_id
		
		));

		if(file_exists(APPLICATION . "/template/admin/$parent_model/add_child-$child_model.php")) {

			$this->template("admin/$parent_model/add_child-$child_model");

		} elseif(file_exists(APPLICATION . "/template/admin/$parent_model/add_child.php")) {

			$this->template("admin/$parent_model/add_child");

		} else {

			$this->template('admin/add_child');

		}
		
	}

}