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

		register_rest_route($namespace, '/' . 'get-products', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array($this, 'lswp_get_products'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'get-product/(?P<id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'lcwp_get_product'),
				'permission_callback' => array($this, 'lswp_api_permission'),
				'args'                => array(),
			),
		));
		register_rest_route($namespace, '/' . 'get-orders', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array($this, 'lswp_get_orders'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'get-contacts', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array($this, 'lswp_get_contacts'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'get-contact/(?P<id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'lcwp_get_contact'),
				'permission_callback' => array($this, 'lswp_api_permission'),
				'args'                => array(),
			),
		));
		register_rest_route($namespace, '/' . 'get-categories', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array($this, 'lswp_get_categories'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'get-category/(?P<id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'lcwp_get_category'),
				'permission_callback' => array($this, 'lswp_api_permission'),
				'args'                => array(),
			),
		));
		register_rest_route($namespace, '/' . 'get-variations/(?P<product_id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'lcwp_get_variations'),
				'permission_callback' => array($this, 'lswp_api_permission'),
				'args'                => array(),
			),
		));
		register_rest_route($namespace, '/' . 'get-variation/(?P<id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'lcwp_get_variation'),
				'permission_callback' => array($this, 'lswp_api_permission'),
				'args'                => array(),
			),
		));
		register_rest_route($namespace, '/' . 'get-attributes', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array($this, 'lcwp_get_attributes'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'get-attribute/(?P<id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'lcwp_get_attribute'),
				'permission_callback' => array($this, 'lswp_api_permission'),
				'args'                => array(),
			),
		));
		register_rest_route($namespace, '/' . 'get-tags', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array($this, 'lcwp_get_tags'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'get-tag/(?P<id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'lcwp_get_tag'),
				'permission_callback' => array($this, 'lswp_api_permission'),
				'args'                => array(),
			),
		));

		//Post routes
		register_rest_route($namespace, '/' . 'upload-image', array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array($this, 'lswp_create_image'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'delete-image', array(
			'methods' => WP_REST_Server::DELETABLE,
			'callback' => array($this, 'lcwp_delete_image'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'create-category', array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array($this, 'lswp_create_category'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'create-product', array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array($this, 'lcwp_create_product'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'update-product', array(
			'methods' => WP_REST_Server::EDITABLE,
			'callback' => array($this, 'lcwp_update_product'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'create-tag', array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array($this, 'lcwp_create_tag'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'update-tag', array(
			'methods' => WP_REST_Server::EDITABLE,
			'callback' => array($this, 'lcwp_update_tag'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'create-attribute', array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array($this, 'lcwp_create_attribute'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'create-variation', array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array($this, 'lcwp_create_variation'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'update-variation', array(
			'methods' => WP_REST_Server::EDITABLE,
			'callback' => array($this, 'lcwp_update_variation'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
		register_rest_route($namespace, '/' . 'test', array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array($this, 'lcwp_test'),
			'permission_callback' => array($this, 'lswp_api_permission'),
			'args' => array(),
		));
	}

	/**
	 * Get a collection of items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */

	//Validate the request
	public function lswp_api_permission()
	{
		$bearer_token = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
		$token = null;
		if ($bearer_token) {
			$parts = explode(' ', $bearer_token);
			if (count($parts) == 2 && $parts[0] === 'Bearer') {
				$token = $parts[1];
			}
		}

		if ($token && get_option('lswp_auth_token') === $token) {
			return true;
		} else {
			return false;
		}
	}

	//Get all products
	public function lswp_get_products()
	{
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$all_products = [];
		$products = get_posts(array(
			'posts_per_page' => 100,
			'paged' => $page,
			'fields' => 'ids',
			'post_type' => 'product',
		));

		foreach ($products as $product) {
			$product = wc_get_product($product);
			$all_products[] = $this->getProductData($product);
		}
		return new WP_REST_Response($all_products, 200);
	}

	public function getProductData($product)
	{
		return [
			'id' => $product->get_id(),
			'name' => $product->get_name(),
			'slug' => $product->get_slug(),
			'permalink' => get_permalink($product->get_id()),
			'date_created' => $product->get_date_created(),
			'date_modified' => $product->get_date_modified(),
			'type' => $product->get_type(),
			'status' => $product->get_status(),
			'featured' => $product->get_featured(),
			'description' => $product->get_description(),
			'short_description' => $product->get_short_description(),
			'sku' => $product->get_sku(),
			'price' => $product->get_price(),
			'regular_price' => $product->get_regular_price(),
			'sale_price' => $product->get_sale_price(),
			'date_on_sale_from' => $product->get_date_on_sale_from(),
			'date_on_sale_to' => $product->get_date_on_sale_to(),
			'on_sale' => $product->is_on_sale(),
			'purchasable' => $product->is_purchasable(),
			'total_sales' => $product->get_total_sales(),
			'virtual' => $product->is_virtual(),
			'downloadable' => $product->is_downloadable(),
			'downloads' => $product->get_downloads(),
			'download_limit' => $product->get_download_limit(),
			'download_expiry' => $product->get_download_expiry(),
			'tax_status' => $product->get_tax_status(),
			'tax_class' => $product->get_tax_class(),
			'manage_stock' => $product->get_manage_stock(),
			'stock_quantity' => $product->get_stock_quantity(),
			'stock_status' => $product->get_stock_status(),
			'back_orders' => $product->get_backorders(),
			'backorders_allowed' => $product->backorders_allowed(),
			'backordered' => $product->is_on_backorder(),
			'sold_individually' => $product->get_sold_individually(),
			'weight' => $product->get_weight(),
			'dimensions' => $product->get_dimensions(),
			'shipping_class_id' => $product->get_shipping_class_id(),
			'upsell_ids' => $product->get_upsell_ids(),
			'cross_sell_ids' => $product->get_cross_sell_ids(),
			'parent_id' => $product->get_parent_id(),
			'purchase_note' => $product->get_purchase_note(),
			'categories' => $this->getCategories($product->get_category_ids()),
			'tags' => $product->get_tag_ids(),
			'images' => $this->getImages($product),
			'attributes' => $this->getAttributes($product),
			'default_attributes' => $product->get_default_attributes(),
			'variations' => $product->get_children(),
		];
	}

	//Get all categories of a product
	public function getCategories($data)
	{
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

	//Get all images
	public function getImages($data)
	{
		$images = [];
		if ($data->get_image_id()) {
			$thumbnail = wp_get_attachment_image_src($data->get_image_id(), 'single-post-thumbnail');
			$images[] = [
				'id' => $data->get_image_id(),
				'src' => $thumbnail[0],
				'thumbnail' => $thumbnail[0],
			];
		}

		if ($data->get_gallery_image_ids() !== null) {
			foreach ($data->get_gallery_image_ids() as $item) {
				$images[] = [
					'id' => $item,
					'src' => wp_get_attachment_url($item),
					'thumbnail' => wp_get_attachment_thumb_url($item),
				];
			}
		}
		return $images;
	}

	//Get all attributes
	public function getAttributes($data)
	{
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

	//Get all categories
	public function lswp_get_categories()
	{
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$args = array(
			'taxonomy'   => "product_cat",
			'number'     => 100,
			'hide_empty' => false,
			'include'    => 'ids',
			'offset'     => ($page - 1) * 100,
		);
		$categories = get_terms($args);

		$all_categories = [];
		foreach ($categories as $category) {
			$all_categories[] = [
				'id' => $category->term_id,
				'name' => $category->name,
				'slug' => $category->slug,
				'parent' => $category->parent,
				'description' => $category->description,
				'display' => $category->display_type,
				'image' => $this->getCategoryImage($category->term_id),
				'menu_order' => $category->menu_order,
				'count' => $category->count,
				'_links' => $this->getCategoryLinks($category->term_id),
				'permalink' => get_category_link($category->term_id),
			];
		}
		return new WP_REST_Response($all_categories, 200);
	}

	//Get category images
	public function getCategoryImage($id)
	{
		$thumbnail_id = get_term_meta($id, 'thumbnail_id', true);
		$image = wp_get_attachment_url($thumbnail_id);
		$image !== false ? $image : $image = null;
		return $image;
	}

	//Get category links
	public function getCategoryLinks($id)
	{
		$links = [
			'self' => [
				'href' => rest_url('lswp/v1/categories/' . $id),
			],
			'collection' => [
				'href' => rest_url('lswp/v1/categories'),
			],
		];
		return $links;
	}

	//Get single category
	public function lcwp_get_category($request)
	{
		$id = $request->get_params();

		if ($category = get_term_by('id', $id['id'], 'product_cat')) {
			$category = $this->getCategoryData($category);
			return new WP_REST_Response($category, 200);
		} else {
			return new WP_Error('no_category', 'Category not found', array('status' => 404));
		}
	}

	public function getCategoryData($category)
	{
		return [
			'id' => $category->term_id,
			'name' => $category->name,
			'slug' => $category->slug,
			'parent' => $category->parent,
			'description' => $category->description,
			'display' => $category->display_type,
			'image' => $this->getCategoryImage($category->term_id),
			'menu_order' => $category->menu_order,
			'count' => $category->count,
			'_links' => $this->getCategoryLinks($category->term_id),
			'permalink' => get_category_link($category->term_id),
		];
	}

	//Get all orders
	public function lswp_get_orders()
	{
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		//get woocommerce orders
		$all_orders = [];
		$orders = get_posts(array(
			'posts_per_page' => 100,
			'paged' => $page,
			'fields' => 'ids',
			'post_type' => 'shop_order',
			'post_status'    => 'any',
		));

		foreach ($orders as $order) {
			$order = wc_get_order($order);

			$all_orders[] = [
				'id' => $order->get_id(),
				'parent_id' => $order->get_parent_id(),
				'order_key' => $order->get_order_key(),
				'created_via' => $order->get_created_via(),
				'version' => $order->get_version(),
				'status' => $order->get_status(),
				'currency' => $order->get_currency(),
				'date_created' => $order->get_date_created(),
				'date_modified' => $order->get_date_modified(),
				'discount_total' => $order->get_discount_total(),
				'discount_tax' => $order->get_discount_tax(),
				'shipping_total' => $order->get_shipping_total(),
				'shipping_tax' => $order->get_shipping_tax(),
				'cart_tax' => $order->get_cart_tax(),
				'total' => $order->get_total(),
				'total_tax' => $order->get_total_tax(),
				'prices_include_tax' => $order->get_prices_include_tax(),
				'customer_id' => $order->get_customer_id(),
				'customer_ip_address' => $order->get_customer_ip_address(),
				'customer_user_agent' => $order->get_customer_user_agent(),
				'customer_note' => $order->get_customer_note(),
				'billing' => [
					'first_name' => $order->get_billing_first_name(),
					'last_name' => $order->get_billing_last_name(),
					'company' => $order->get_billing_company(),
					'address_1' => $order->get_billing_address_1(),
					'address_2' => $order->get_billing_address_2(),
					'city' => $order->get_billing_city(),
					'state' => $order->get_billing_state(),
					'postcode' => $order->get_billing_postcode(),
					'country' => $order->get_billing_country(),
				],
				'shipping' => [
					'first_name' => $order->get_shipping_first_name(),
					'last_name' => $order->get_shipping_last_name(),
					'company' => $order->get_shipping_company(),
					'address_1' => $order->get_shipping_address_1(),
					'address_2' => $order->get_shipping_address_2(),
					'city' => $order->get_shipping_city(),
					'state' => $order->get_shipping_state(),
					'postcode' => $order->get_shipping_postcode(),
					'country' => $order->get_shipping_country(),
				],
				'payment_method' => $order->get_payment_method(),
				'payment_method_title' => $order->get_payment_method_title(),
				'transaction_id' => $order->get_transaction_id(),
				'date_paid' => $order->get_date_paid(),
				'date_completed' => $order->get_date_completed(),
				'cart_hash' => $order->get_cart_hash(),
				'meta_data' => $order->get_meta_data(),
				'line_items' => $this->getLineItems($order->get_items()),
				'tax_lines' => $this->getTaxLines($order->get_items('tax')),
				'shipping_lines' => $this->getShippingLines($order->get_items('shipping')),
				'fee_lines' => $this->getFeeLines($order->get_items('fee')),
				'coupon_lines' => $this->getCouponLines($order->get_items('coupon')),
				'refunds' => $this->getRefunds($order->get_refunds()),
				'currency_symbol' => get_woocommerce_currency_symbol($order->get_currency()),
				'_links' => [
					'self' => [
						'href' => rest_url('wc/v3/orders/' . $order->get_id()),
					],
					'collection' => [
						'href' => rest_url('wc/v3/orders'),
					],
				],
			];
		}
		return new WP_REST_Response($all_orders, 200);
	}

	// Get line items
	public function getLineItems($data)
	{
		$line_items = [];
		foreach ($data as $item) {
			$product = wc_get_product($item->get_product_id());

			$line_items[] = [
				'id' => $item->get_product_id(),
				'name' => $item->get_name(),
				'product_id' => $item->get_product_id(),
				'variation_id' => $item->get_variation_id(),
				'quantity' => $item->get_quantity(),
				'subtotal' => $item->get_subtotal(),
				'subtotal_tax' => $item->get_subtotal_tax(),
				'total' => $item->get_total(),
				'total_tax' => $item->get_total_tax(),
				'taxes' => $item->get_taxes(),
				'sku' => $product->get_sku(),
				'meta_data' => $item->get_meta_data(),
			];
		}
		return $line_items;
	}

	// Get tax lines
	public function getTaxLines($data)
	{
		$tax_lines = [];
		foreach ($data as $item) {
			$tax_lines[] = [
				'id' => $item->get_rate_id(),
				'rate_code' => $item->get_rate_code(),
				'rate_id' => $item->get_rate_id(),
				'label' => $item->get_label(),
				'compound' => $item->get_compound(),
				'tax_total' => $item->get_tax_total(),
				'shipping_tax_total' => $item->get_shipping_tax_total(),
			];
		}
		return $tax_lines;
	}

	// Get shipping lines
	public function getShippingLines($data)
	{
		$shipping_lines = [];
		foreach ($data as $item) {
			$shipping_lines[] = [
				'id' => $item->get_instance_id(),
				'method_id' => $item->get_method_id(),
				'method_title' => $item->get_method_title(),
				'total' => $item->get_total(),
				'taxes' => $item->get_taxes(),
			];
		}
		return $shipping_lines;
	}

	// Get fee lines
	public function getFeeLines($data)
	{
		$fee_lines = [];
		foreach ($data as $item) {
			$fee_lines[] = [
				'id' => $item->get_id(),
				'name' => $item->get_name(),
				'tax_class' => $item->get_tax_class(),
				'tax_status' => $item->get_tax_status(),
				'total' => $item->get_total(),
				'total_tax' => $item->get_total_tax(),
				'taxes' => $item->get_taxes(),
			];
		}
		return $fee_lines;
	}

	// Get coupon lines
	public function getCouponLines($data)
	{
		$coupon_lines = [];
		foreach ($data as $item) {
			$coupon_lines[] = [
				'id' => $item->get_id(),
				'code' => $item->get_code(),
				'discount' => $item->get_discount(),
				'discount_tax' => $item->get_discount_tax(),
			];
		}
		return $coupon_lines;
	}

	// Get refunds
	public function getRefunds($data)
	{
		$refunds = [];
		foreach ($data as $item) {
			$refunds[] = [
				'id' => $item->get_id(),
				'reason' => $item->get_reason(),
				'total' => $item->get_amount(),
				'line_items' => $this->getLineItems($item->get_items()),
				'tax_lines' => $this->getTaxLines($item->get_taxes()),
				'shipping_lines' => $this->getShippingLines($item->get_shipping_methods()),
				'fee_lines' => $this->getFeeLines($item->get_fees()),
				'coupon_lines' => $this->getCouponLines($item->get_coupons()),
			];
		}
		return $refunds;
	}

	//Get all contacts
	public function lswp_get_contacts()
	{
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$all_customers = [];
		$customers = new WP_User_Query(
			array(
				'fields' => 'ID',
				'role' => 'customer',
				'number' => 100,
				'paged' => $page,
			)
		);

		foreach ($customers->get_results() as $customer) {
			$customer = new WC_Customer($customer);

			$all_customers[] = $this->getContactData($customer);
		}
		return new WP_REST_Response($all_customers, 200);
	}

	//Get Customer data
	public function getContactData($customer)
	{
		return [
			'id' => $customer->get_id(),
			'date_created' => $customer->get_date_created(),
			'date_modified' => $customer->get_date_modified(),
			'email' => $customer->get_email(),
			'first_name' => $customer->get_first_name(),
			'last_name' => $customer->get_last_name(),
			'role' => $customer->get_role(),
			'username' => $customer->get_username(),
			'billing' => [
				'first_name' => $customer->get_billing_first_name(),
				'last_name' => $customer->get_billing_last_name(),
				'company' => $customer->get_billing_company(),
				'address_1' => $customer->get_billing_address_1(),
				'address_2' => $customer->get_billing_address_2(),
				'city' => $customer->get_billing_city(),
				'state' => $customer->get_billing_state(),
				'postcode' => $customer->get_billing_postcode(),
				'country' => $customer->get_billing_country(),
				'email' => $customer->get_billing_email(),
				'phone' => $customer->get_billing_phone(),
			],
			'shipping' => [
				'first_name' => $customer->get_shipping_first_name(),
				'last_name' => $customer->get_shipping_last_name(),
				'company' => $customer->get_shipping_company(),
				'address_1' => $customer->get_shipping_address_1(),
				'address_2' => $customer->get_shipping_address_2(),
				'city' => $customer->get_shipping_city(),
				'state' => $customer->get_shipping_state(),
				'postcode' => $customer->get_shipping_postcode(),
				'country' => $customer->get_shipping_country(),
			],
			'is_paying_customer' => $customer->is_paying_customer(),
			'avatar_url' => $customer->get_avatar_url(),
			'meta_data' => $customer->get_meta_data(),
			'_links' => [
				'self' => [
					'href' => rest_url('wc/v3/customers/' . $customer->get_id()),
				],
				'collection' => [
					'href' => rest_url('wc/v3/customers'),
				],
			],
		];
	}

	//Get single customer data
	//Get all contacts
	public function lcwp_get_contact($request)
	{
		$id = $request->get_params();
		$customer = new WC_Customer($id['id']);

		if ($customer->get_id()) {
			return new WP_REST_Response($this->getContactData($customer), 200);
		} else {
			return new WP_Error('no_customer', 'Customer not found', array('status' => 404));
		}
	}

	//Get All variaons of a product
	public function lcwp_get_variations($request)
	{
		$all_variations = [];
		$product_id = $request->get_params()['product_id'];
		$product = wc_get_product($product_id);
		$variations = $product->get_children();

		foreach ($variations as $variation) {
			$data = new WC_Product_Variation($variation);
			$all_variations[] = $this->getVariationData($data);
		}
		return new WP_REST_Response($all_variations, 200);
	}

	//Get Product variation
	public function lcwp_get_variation($request)
	{
		$id = $request->get_params();
		$data = new WC_Product_Variation($id['id']);

		if (get_post_type($data->get_id()) == 'product_variation') {
			$variation = $this->getVariationData($data);
			return new WP_REST_Response($variation, 200);
		} else {
			return new WP_Error('no_product_variation', 'Product variation not found', array('status' => 404));
		}
	}

	//Get Product variation data
	public function getVariationData($data)
	{
		return [
			'id' => $data->get_id(),
			'name' => $data->get_name(),
			'date_created' => $data->get_date_created(),
			'date_modified' => $data->get_date_modified(),
			'description' => $data->get_description(),
			'pemalink' => $data->get_permalink(),
			'sku' => $data->get_sku(),
			'price' => $data->get_price(),
			'regular_price' => $data->get_regular_price(),
			'sale_Price' => $data->get_sale_price(),
			'date_on_sale_from' => $data->get_date_on_sale_from(),
			'date_on_sale_to' => $data->get_date_on_sale_to(),
			'on_sale' => $data->is_on_sale(),
			'status' => $data->get_status(),
			'purchasable' => $data->is_purchasable(),
			'virtual' => $data->is_virtual(),
			'downloadable' => $data->is_downloadable(),
			'downloads' => $data->get_downloads(),
			'download_limit' => $data->get_download_limit(),
			'download_expiry' => $data->get_download_expiry(),
			'tax_status' => $data->get_tax_status(),
			'tax_class' => $data->get_tax_class(),
			'manage_stock' => $data->get_manage_stock(),
			'stock_quantity' => $data->get_stock_quantity(),
			'stock_status' => $data->get_stock_status(),
			'backorders' => $data->get_backorders(),
			'backorders_allowed' => $data->backorders_allowed(),
			'backordered' => $data->is_on_backorder(),
			'weight' => $data->get_weight(),
			'dimentions' => $data->get_dimensions(),
			'shipping_class' => $data->get_shipping_class(),
			'shipping_class_id' => $data->get_shipping_class_id(),
			'image' => $data->get_image() !== '' ? [
				'id' => $data->get_image_id(),
				'src' => wp_get_attachment_url($data->get_image_id()),
				'thumbnail' => wp_get_attachment_thumb_url($data->get_image_id()),
			] : '',
			'attributes' => $this->getVariationAttribute($data->get_attributes()),
			'menu_order' => $data->get_menu_order(),
			'meta_data' => $data->get_meta_data(),
		];
	}

	public function getVariationAttribute($data)
	{
		$attributes = [];
		foreach ($data as $key => $item) {
			$attributes[] = [
				'id' => wc_attribute_taxonomy_id_by_name($key),
				'name' => wc_attribute_label($key),
				'option' => $item,
			];
		}
		return $attributes;
	}

	//Get single category
	public function lcwp_get_product($request)
	{
		$id = $request->get_params();
		$product = wc_get_product($id['id']);

		if ($product) {
			return new WP_REST_Response($this->getProductData($product), 200);
		} else {
			return new WP_Error('no_product', 'Product not found', array('status' => 404));
		}
	}

	//Get a single attribute
	public function lcwp_get_attribute($request)
	{
		$id = $request->get_params();
		$attribute = wc_get_attribute($id['id']);

		if ($attribute) {
			return new WP_REST_Response($attribute, 200);
		} else {
			return new WP_Error('no_attribute', 'Attribute not found', array('status' => 404));
		}

		$attributes = wc_get_attribute_taxonomies();
		$all_attributes = [];
		foreach ($attributes as $attribute) {
			$all_attributes[] = [
				'id' => $attribute->attribute_id,
				'name' => $attribute->attribute_label,
				'slug' => $attribute->attribute_name,
				'type' => $attribute->attribute_type,
				'order_by' => $attribute->attribute_orderby,
				'has_archives' => $attribute->attribute_public,
			];
		}
		return new WP_REST_Response($all_attributes, 200);
	}

	//Get all attributes
	public function lcwp_get_attributes()
	{
		$attributes = wc_get_attribute_taxonomies();
		$all_attributes = [];
		foreach ($attributes as $attribute) {
			$all_attributes[] = [
				'id' => $attribute->attribute_id,
				'name' => $attribute->attribute_label,
				'slug' => $attribute->attribute_name,
				'type' => $attribute->attribute_type,
				'order_by' => $attribute->attribute_orderby,
				'has_archives' => $attribute->attribute_public,
			];
		}
		return new WP_REST_Response($all_attributes, 200);
	}

	//Get all tags
	public function lcwp_get_tags()
	{
		$terms = get_terms('product_tag');
		$term_array = array();
		if (!empty($terms) && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				$term_array[] = [
					'id' => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug,
					'count' => $term->count,
				];
			}
		}
		return new WP_REST_Response($term_array, 200);
	}

	public function lcwp_get_tag($request)
	{
		$id = $request->get_params();
		$term = get_term($id['id'], 'product_tag');

		if ($term) {
			return new WP_REST_Response($term, 200);
		} else {
			return new WP_Error('no_tag', 'Tag not found', array('status' => 404));
		}
	}

	//Create an image
	public function lswp_create_image($request)
	{
		try {
			$image =  $request->get_params()['image'];
			$upload_dir = wp_upload_dir();
			$image_data = file_get_contents($image);

			$filename = $this->generateRandomString() . '.' . pathinfo($image, PATHINFO_EXTENSION);

			if (wp_mkdir_p($upload_dir['path'])) {
				$file = $upload_dir['path'] . '/' . $filename;
			} else {
				$file = $upload_dir['basedir'] . '/' . $filename;
			}

			file_put_contents($file, $image_data);

			$wp_filetype = wp_check_filetype($filename, null);
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => sanitize_file_name($filename),
				'post_content' => '',
				'post_status' => 'inherit',
			);
			$attach_id = wp_insert_attachment($attachment, $file);
			require_once ABSPATH . 'wp-admin/includes/image.php';
			$attach_data = wp_generate_attachment_metadata($attach_id, $file);
			wp_update_attachment_metadata($attach_id, $attach_data);

			//get the image by id
			$image = wp_get_attachment_image_src($attach_id, 'full');
			return new WP_REST_Response([
				'id' => $attach_id,
				'source_url' => $image[0],
			], 200);
		} catch (Exception $e) {
			return new WP_Error('no_image', $e->getMessage(), array('status' => 404));
		}
	}

	//Delete an image
	public function lswp_delete_image($request)
	{
		$id = $request->get_params();
		$attachment = get_post($id['id']);
		if ($attachment) {
			wp_delete_attachment($id['id'], true);
			return new WP_REST_Response([
				'deleted' => true,
				'message' => 'Image deleted successfully',
			], 200);
		} else {
			return new WP_Error('no_image', 'Image not found', array('status' => 404));
		}
	}

	public function generateRandomString($length = 10)
	{
		return substr(str_shuffle(str_repeat(
			$x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
			ceil($length / strlen($x))
		)), 1, $length);
	}

	//Create category
	public function lswp_create_category($request)
	{
		$data = $request->get_params();
		try {
			$data = wp_insert_term($data['name'], 'product_cat', array(
				'description' => $data['description'],
			));

			$data = json_decode(json_encode($data), FALSE);

			if (isset($data) && isset($data->term_id)) {
				if (isset($data) && isset($data->image) && $data->image !== null) {
					add_term_meta($data->term_id, 'thumbnail_id', (int)$data->image);
				}
				$category = get_term_by('id', $data->term_id, 'product_cat');
				return new WP_REST_Response($this->getCategoryData($category), 200);
			} else if (
				isset($data) &&
				isset($data->errors) && isset($data->errors->term_exists) &&
				isset($data->errors->term_exists[0])
			) {
				return new WP_Error('term_exists', $data->errors->term_exists[0], array('status' => 404));
			} else {
				return new WP_Error('no_category', 'Category not created', array('status' => 404));
			}
		} catch (Exception $e) {
			return new WP_Error('no_category', $e->getMessage(), array('status' => 404));
		}
	}

	//Update product
	public function lswp_update_product($request)
	{
		//update product
		$data = $request->get_params();
		$product = wc_get_product($data['id']);
		if ($product) {
			$product->set_name($data['name']);
			$product->set_description($data['description']);
			$product->set_short_description($data['short_description']);
			$product->set_regular_price($data['regular_price']);
			$product->set_sale_price($data['sale_price']);
			$product->set_stock_quantity($data['stock_quantity']);
			$product->set_stock_status($data['stock_status']);
			$product->set_manage_stock($data['manage_stock']);
			$product->set_backorders($data['backorders']);
			$product->set_sold_individually($data['sold_individually']);
			$product->set_status($data['status']);
			$product->set_catalog_visibility($data['catalog_visibility']);
			$product->set_featured($data['featured']);
			$product->set_reviews_allowed($data['reviews_allowed']);
			$product->set_weight($data['weight']);
			$product->set_length($data['length']);
			$product->set_width($data['width']);
			$product->set_height($data['height']);
			$product->set_sku($data['sku']);
			$product->set_tax_status($data['tax_status']);
			$product->set_tax_class($data['tax_class']);
			$product->set_purchase_note($data['purchase_note']);
			$product->set_menu_order($data['menu_order']);
			$product->set_virtual($data['virtual']);
			$product->set_downloadable($data['downloadable']);
			$product->set_price($data['price']);
			$product->set_attributes($data['attributes']);
			$product->set_category_ids($data['category_ids']);
			$product->set_tag_ids($data['tag_ids']);
			$product->set_gallery_image_ids($data['gallery_image_ids']);
			$product->set_image_id($data['image_id']);
			$product->set_download_limit($data['download_limit']);
			$product->set_download_expiry($data['download_expiry']);
			$product->set_downloads($data['downloads']);
			$product->set_parent_id($data['parent_id']);
			$product->set_reviews_allowed($data['reviews_allowed']);
			$product->set_upsell_ids($data['upsell_ids']);
			$product->set_cross_sell_ids($data['cross_sell_ids']);
		}
	}

	//Create tag
	public function lcwp_create_tag($request)
	{
		$data = $request->get_params();
		try {
			$data = wp_insert_term($data['name'], 'product_tag');

			$data = json_decode(json_encode($data), FALSE);

			if (isset($data) && isset($data->term_id)) {
				$tag = get_term_by('id', $data->term_id, 'product_tag');
				return new WP_REST_Response($tag, 200);
			} else if (
				isset($data) &&
				isset($data->errors) && isset($data->errors->term_exists) &&
				isset($data->errors->term_exists[0])
			) {
				return new WP_Error('term_exists', $data->errors->term_exists[0], array('status' => 404));
			} else {
				return new WP_Error('no_tag', 'Tag not created', array('status' => 404));
			}
		} catch (Exception $e) {
			return new WP_Error('no_tag', $e->getMessage(), array('status' => 404));
		}
	}

	//Update tag
	public function lcwp_update_tag($request)
	{
		$data = $request->get_params();
		$tag = wp_update_term($data['id'], 'product_tag', array(
			'name' => $data['name'],
		));
		$tag = get_term_by('id', $data['id'], 'product_tag');
		return new WP_REST_Response($tag, 200);
	}

	//Create Attribute
	public function lcwp_create_attribute($request)
	{
		$data = $request->get_params();
		try {
			$data = wc_create_attribute(array(
				'name' => $data['name'],
				'slug' => $data['slug'],
				'type' => $data['type'],
				'order_by' => $data['order_by'],
				'has_archives' => $data['has_archives']
			));

			$data = json_decode(json_encode($data), FALSE);

			if (isset($data) && gettype($data) === 'integer') {
				$attribute = wc_get_attribute($data);
				return new WP_REST_Response($attribute, 200);
			} else if (
				isset($data) &&
				isset($data->errors) && isset($data->errors->invalid_product_attribute_slug_already_exists) &&
				isset($data->errors->invalid_product_attribute_slug_already_exists[0])
			) {
				return new WP_Error(
					'duplicate_attribute',
					$data->errors->invalid_product_attribute_slug_already_exists[0],
					array('status' => 404)
				);
			} else {
				return new WP_Error('no_attribute', 'Attribute not created', array('status' => 404));
			}
		} catch (Exception $e) {
			return new WP_Error('no_attribute', $e->getMessage(), array('status' => 404));
		}
	}

	//Create product
	public function lcwp_create_product($request)
	{
		$data = $request->get_params();
		try {
			if ($data['type'] === 'simple') {
				$product = new WC_Product_Simple();
			} else {
				$product = new WC_Product_Variable();
			}
			$product = $this->setProductData($product, $data);

			$product = wc_get_product($product->get_id());

			return new WP_REST_Response($this->getProductData($product), 200);
		} catch (Exception $e) {
			return new WP_Error('no_product', $e->getMessage(), array('status' => 404));
		}
	}

	//Update product 
	public function lcwp_update_product($request)
	{
		try {
			$data = $request->get_params();

			if ($data['type'] === 'simple') {
				$product = new WC_Product_Simple($data['id']);
			} else {
				$product = new WC_Product_Variable($data['id']);
			}

			if ($product === false) {
				return new WP_Error('no_product', 'Product not found', array('status' => 404));
			} else {
				$product = $this->setProductData($product, $data);

				$product = wc_get_product($product->get_id());
				return new WP_REST_Response($this->getProductData($product), 200);
			}
		} catch (Exception $e) {
			return new WP_Error('no_product', $e->getMessage(), array('status' => 404));
		}
	}

	//Set product data
	public function setProductData($product, $data)
	{
		$product->set_name($data['name']);
		$product->set_slug($data['slug']);
		$product->set_status($data['status']);
		$product->set_featured($data['featured']);
		$product->set_price($data['price']);
		$product->set_regular_price($data['regular_price']);
		$product->set_sale_price($data['sale_price']);
		$product->set_date_on_sale_from($data['date_on_sale_from']);
		$product->set_date_on_sale_to($data['date_on_sale_to']);
		$product->set_purchase_note($data['purchase_note']);
		$product->set_description($data['description']);
		$product->set_short_description($data['short_description']);
		$product->set_category_ids($data['category_ids']);

		if (isset($data['thumbnail_image']) && isset($data['thumbnail_image']['id'])) {
			$product->set_image_id($data['thumbnail_image']['id']);
		}

		$product->set_gallery_image_ids($data['gallery_images']);
		$product->set_tag_ids($data['tags']);
		$product->set_upsell_ids($data['upsell_ids']);
		$product->set_cross_sell_ids($data['cross_sell_ids']);
		$product->set_attributes(['attributes']);
		$product->set_stock_status($data['stock_status']);
		$product->set_stock_quantity($data['stock_quantity']);
		$product->set_manage_stock($data['manage_stock']);
		$product->save();

		//Create attributes
		$attributes = [];

		if (isset($data['attributes']) && is_array($data['attributes']) && count($data['attributes']) > 0) {
			// Loop through defined attribute data
			foreach ($data['attributes'] as $attr) {
				$attribute = new WC_Product_Attribute();
				$attribute->set_id(0);
				$attribute->set_name($attr['name']);
				$attribute->set_options($attr['options']);
				$attribute->set_visible(true);
				$attribute->set_variation(true);
				$attributes[] = $attribute;
			}
		}

		if (count($attributes) > 0) {
			$product->set_attributes($attributes);
			$product->save();
		}

		return $product;
	}

	//Create variation
	public function lcwp_create_variation($request)
	{
		$data = $request->get_params();
		try {
			$variation = new WC_Product_Variation();
			$variation = $this->setVariationData($variation, $data);

			$variation = new WC_Product_Variation($variation->get_id());

			$variation = $this->getVariationData($variation);
			return new WP_REST_Response($variation, 200);
		} catch (Exception $e) {
			return new WP_Error('no_variation', $e->getMessage(), array('status' => 404));
		}
	}

	//Update variation
	public function lcwp_update_variation($request)
	{
		try {
			$data = $request->get_params();
			$variation = new WC_Product_Variation($data['id']);

			$variation = $this->setVariationData($variation, $data);
			
			$variation = new WC_Product_Variation($variation->get_id());

			$variation = $this->getVariationData($variation);
			return new WP_REST_Response($variation, 200);
		} catch (Exception $e) {
			return new WP_Error('no_variation', $e->getMessage(), array('status' => 404));
		}
	}

	//Set variation data
	public function setVariationData($variation, $data)
	{
		$variation->set_parent_id($data['parent_id']);
		$variation->set_description($data['description']);
		$variation->set_price($data['price']);
		$variation->set_regular_price($data['regular_price']);
		$variation->set_sale_price($data['sale_price']);
		$variation->set_date_on_sale_from($data['date_on_sale_from']);
		$variation->set_date_on_sale_to($data['date_on_sale_to']);

		if (isset($data['image']) && $data['image'] !== null) {
			$variation->set_image_id($data['image']);
		}

		$variation->set_manage_stock($data['manage_stock']);
		$variation->set_stock_quantity($data['stock_quantity']);
		$variation->set_stock_status($data['stock_status']);

		if (
			isset($data['attributes']) && count($data['attributes']) > 0 &&
			$data['attributes']['name'] && $data['attributes']['option']
		) {
			$variation->set_attributes([sanitize_title($data['attributes']['name']) => $data['attributes']['option']]);
			// update_post_meta($variation->id, 'attribute_' . sanitize_title($data['attributes']['name']), $data['attributes']['option']);
		}

		$variation->save();

		$product = wc_get_product($data['parent_id']);
		$product->save();

		return $variation;
	}

	public function lcwp_test()
	{
		$product = new WC_Product_Variable();
		$product->set_description('T-shirt variable description');
		$product->set_name('T-shirt variable');
		$product->set_sku('test-shirt');
		$product->set_price(1);
		$product->set_regular_price(1);
		$product->set_stock_status();
		$product->save();

		$atts = [];
		$atts[] = $this->pricode_create_attributes('color', ['red', 'green']);
		$atts[] = $this->pricode_create_attributes('size', ['S', 'M']);

		//Adding attributes to the created product
		$product->set_attributes($atts);
		$product->save();

		$data = new stdClass();
		$data->sku = 'sku-123';
		$data->price = '10';
		$this->pricode_create_variations($product->get_id(), ['color' => 'red', 'size' => 'M'], $data);
		return $product;
	}

	public function pricode_create_attributes($name, $options)
	{
		$attribute = new WC_Product_Attribute();
		$attribute->set_id(0);
		$attribute->set_name($name);
		$attribute->set_options($options);
		$attribute->set_visible(true);
		$attribute->set_variation(true);
		return $attribute;
	}

	function pricode_create_variations($product_id, $values, $data)
	{
		$variation = new WC_Product_Variation();
		$variation->set_parent_id($product_id);
		$variation->set_attributes($values);
		$variation->set_status('publish');
		$variation->set_sku($data->sku);
		$variation->set_price($data->price);
		$variation->set_regular_price($data->price);
		$variation->set_stock_status();
		$variation->save();
		$product = wc_get_product($product_id);
		$product->save();
		return $product;
	}
}

function init_rest_api_endpoint()
{
	$endpoint = new Lswp_api();
	$endpoint->register_routes();
}
add_action('rest_api_init', 'init_rest_api_endpoint');
