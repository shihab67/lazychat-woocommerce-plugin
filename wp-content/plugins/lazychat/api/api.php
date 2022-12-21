<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

class Lswp_api extends WP_REST_Controller
{

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes()
	{
		$version = '1';
		$namespace = 'lazychat/v' . $version;
		$base = 'get-products';

		register_rest_route($namespace, '/' . $base, array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array($this, 'lswp_get_products'),
			'permission_callback' => function () {
				return true;
			},
			'args'                => array(),
		));
		// register_rest_route($namespace, '/' . $base, array(
		// 	array(
		// 		'methods'             => WP_REST_Server::READABLE,
		// 		'callback'            => array($this, 'lswp_get_products'),
		// 		// 'permission_callback' => array( $this, 'get_items_permissions_check' ),
		// 	),
		// ));
		// register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)', array(
		//   array(
		//     'methods'             => WP_REST_Server::READABLE,
		//     'callback'            => array( $this, 'get_item' ),
		//     'permission_callback' => array( $this, 'get_item_permissions_check' ),
		//     'args'                => array(
		//       'context' => array(
		//         'default' => 'view',
		//       ),
		//     ),
		//   ),
		//   array(
		//     'methods'             => WP_REST_Server::EDITABLE,
		//     'callback'            => array( $this, 'update_item' ),
		//     'permission_callback' => array( $this, 'update_item_permissions_check' ),
		//     'args'                => $this->get_endpoint_args_for_item_schema( false ),
		//   ),
		//   array(
		//     'methods'             => WP_REST_Server::DELETABLE,
		//     'callback'            => array( $this, 'delete_item' ),
		//     'permission_callback' => array( $this, 'delete_item_permissions_check' ),
		//     'args'                => array(
		//       'force' => array(
		//         'default' => false,
		//       ),
		//     ),
		//   ),
		// ) );
		// register_rest_route( $namespace, '/' . $base . '/schema', array(
		//   'methods'  => WP_REST_Server::READABLE,
		//   'callback' => array( $this, 'get_public_item_schema' ),
		// ) );
	}

	/**
	 * Get a collection of items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */

	public function lswp_get_products()
	{
		$all_products = [];
		$products = get_posts(array(
			'limit' => -1,
			'fields' => 'ids',
			'post_type' => 'product',
		));

		foreach ($products as $product) {
			$product = wc_get_product($product);

			$all_products[] = [
				'id' => $product->get_id(),
				'type' => $product->get_type(),
				'name' => $product->get_name(),
				'slug' => $product->get_slug(),
				'date_created' => $product->get_date_created(),
				'date_modified' => $product->get_date_modified(),
				'status' => $product->get_status(),
				'featured' => $product->get_featured(),
				'descripion' => $product->get_description(),
				'short_description' => $product->get_short_description(),
				'sku' => $product->get_sku(),
				'permalink' => get_permalink($product->get_id()),
				'price' => $product->get_price(),
				'regular_price' => $product->get_regular_price(),
				'sale_price' => $product->get_sale_price(),
				'on_sale' => $product->is_on_sale(),
				'date_on_sale_from' => $product->get_date_on_sale_from(),
				'date_on_sale_to' => $product->get_date_on_sale_to(),
				'total_sales' => $product->get_total_sales(),
				'tax_status' => $product->get_tax_status(),
				'tax_class' => $product->get_tax_class(),
				'manage_stock' => $product->get_manage_stock(),
				'stock_quantity' => $product->get_stock_quantity(),
				'stock_status' => $product->get_stock_status(),
				'back_orders' => $product->get_backorders(),
				'sold_individually' => $product->get_sold_individually(),
				'purchase_note' => $product->get_purchase_note(),
				'shipping_class_id' => $product->get_shipping_class_id(),
				'weight' => $product->get_weight(),
				'dimensions' => $product->get_dimensions(),
				'upsell_ids' => $product->get_upsell_ids(),
				'cross_sell_ids' => $product->get_cross_sell_ids(),
				'parent_id' => $product->get_parent_id(),
				'children' => $product->get_children(),
				'attributes' => $this->getAttributes($product),
				'categories' => $this->getCategories($product->get_category_ids()),
				'tags' => $product->get_tag_ids(),
				'downloads' => $product->get_downloads(),
				'downloadable' => $product->get_downloadable(),
				'download_limit' => $product->get_download_limit(),
				'images' => $this->getImages($product->get_gallery_image_ids()),
			];
		}
		return new WP_REST_Response($all_products, 200);
	}

	public function getCategories($data) {
		$categories = [];
		if ($data !== null) {
			foreach ($data as $item) {
				$categories[] = [
					'id' => $item,
					'name' => get_cat_name($item) === "" ? 'Uncategorized' : get_cat_name($item),
					'slug' => get_category($item)->slug,
					'permalink' => get_category_link($item),
				];
			}
		}
		return $categories;
	}

	public function getImages($data) {
		$images = [];
		if ($data !== null) {
			foreach ($data as $item) {
				$images[] = [
					'id' => $item,
					'src' => wp_get_attachment_url($item),
					'thumbnail' => wp_get_attachment_thumb_url($item),
				];
			}
		}
		return $images;
	}

	public function getAttributes($data) {
		$attributes = [];
		if ($data !== null) {
			foreach ($data->get_attributes() as $item) {
				$attributes[] = [
					'id' => $item->get_id(),
					'name' => $item->get_name(),
					'options' => $item->get_options(),
					'position' => $item->get_position(),
					'visible' => $item->get_visible(),
					'variation' => $item->get_variation(),
				];
			}
		}
		return $attributes;
	}

	public function get_items($request)
	{
		$items = array(); //do a query, call another class, etc
		$data = array();
		foreach ($items as $item) {
			$itemdata = $this->prepare_item_for_response($item, $request);
			$data[] = $this->prepare_response_for_collection($itemdata);
		}

		return new WP_REST_Response($data, 200);
	}

	/**
	 * Get one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_item($request)
	{
		//get parameters from request
		$params = $request->get_params();
		$item = array(); //do a query, call another class, etc
		$data = $this->prepare_item_for_response($item, $request);

		//return a response or error based on some conditional
		if (1 == 1) {
			return new WP_REST_Response($data, 200);
		} else {
			return new WP_Error('code', __('message', 'text-domain'));
		}
	}

	/**
	 * Create one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function create_item($request)
	{
		$item = $this->prepare_item_for_database($request);

		if (function_exists('slug_some_function_to_create_item')) {
			$data = slug_some_function_to_create_item($item);
			if (is_array($data)) {
				return new WP_REST_Response($data, 200);
			}
		}

		return new WP_Error('cant-create', __('message', 'text-domain'), array('status' => 500));
	}

	/**
	 * Update one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item($request)
	{
		$item = $this->prepare_item_for_database($request);

		if (function_exists('slug_some_function_to_update_item')) {
			$data = slug_some_function_to_update_item($item);
			if (is_array($data)) {
				return new WP_REST_Response($data, 200);
			}
		}

		return new WP_Error('cant-update', __('message', 'text-domain'), array('status' => 500));
	}

	/**
	 * Delete one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function delete_item($request)
	{
		$item = $this->prepare_item_for_database($request);

		if (function_exists('slug_some_function_to_delete_item')) {
			$deleted = slug_some_function_to_delete_item($item);
			if ($deleted) {
				return new WP_REST_Response(true, 200);
			}
		}

		return new WP_Error('cant-delete', __('message', 'text-domain'), array('status' => 500));
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_items_permissions_check($request)
	{
		//return true; <--use to make readable by all
		return current_user_can('edit_something');
	}

	/**
	 * Check if a given request has access to get a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_item_permissions_check($request)
	{
		return $this->get_items_permissions_check($request);
	}

	/**
	 * Check if a given request has access to create items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function create_item_permissions_check($request)
	{
		return current_user_can('edit_something');
	}

	/**
	 * Check if a given request has access to update a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function update_item_permissions_check($request)
	{
		return $this->create_item_permissions_check($request);
	}

	/**
	 * Check if a given request has access to delete a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function delete_item_permissions_check($request)
	{
		return $this->create_item_permissions_check($request);
	}

	/**
	 * Prepare the item for create or update operation
	 *
	 * @param WP_REST_Request $request Request object
	 * @return WP_Error|object $prepared_item
	 */
	protected function prepare_item_for_database($request)
	{
		return array();
	}

	/**
	 * Prepare the item for the REST response
	 *
	 * @param mixed $item WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
	public function prepare_item_for_response($item, $request)
	{
		return array();
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params()
	{
		return array(
			'page'     => array(
				'description'       => 'Current page of the collection.',
				'type'              => 'integer',
				'default'           => 1,
				'sanitize_callback' => 'absint',
			),
			'per_page' => array(
				'description'       => 'Maximum number of items to be returned in result set.',
				'type'              => 'integer',
				'default'           => 10,
				'sanitize_callback' => 'absint',
			),
			'search'   => array(
				'description'       => 'Limit results to those matching a string.',
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
		);
	}
}
// function lswp_get_products()
// {
// 	//get all products
// 	return get_posts([
// 		'post_type' => 'product',
// 		'posts_per_page' => -1
// 	]);
// }

function init_rest_api_endpoint()
{
	$endpoint = new Lswp_api();
	$endpoint->register_routes();
}
add_action('rest_api_init', 'init_rest_api_endpoint');
