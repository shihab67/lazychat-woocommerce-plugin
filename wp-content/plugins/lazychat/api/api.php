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
			'descripion' => $product->get_description(),
			'short_description' => $product->get_short_description(),
			'sku' => $product->get_sku(),
			'price' => $product->get_price(),
			'regular_price' => $product->get_regular_price(),
			'sale_price' => $product->get_sale_price(),
			'date_on_sale_from' => $product->get_date_on_sale_from(),
			'date_on_sale_to' => $product->get_date_on_sale_to(),
			'on_sale' => $product->is_on_sale(),
			'purchaseable' => $product->is_purchasable(),
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
			$category = [
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
			return new WP_REST_Response($category, 200);
		} else {
			return new WP_Error('no_category', 'Category not found', array('status' => 404));
		}
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

			$all_customers[] = [
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
		return new WP_REST_Response($all_customers, 200);
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
}

function init_rest_api_endpoint()
{
	$endpoint = new Lswp_api();
	$endpoint->register_routes();
}
add_action('rest_api_init', 'init_rest_api_endpoint');
