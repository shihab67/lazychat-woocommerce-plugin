<?php
/**
 * This file initializes all the available api endpoints of the plugin.
 *
 * @package LazyChat WooCommerce Plugin
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Lcwp_Api' ) ) {
	/**
	 * This class handles all the api endpoints of the plugin.
	 */
	class Lcwp_Api extends WP_REST_Controller {
		/**
		 * Register the routes for the objects of the controller.
		 */
		public function register_routes() {
			$version   = '1';
			$namespace = 'lazychat/v' . $version;
			register_rest_route(
				$namespace,
				'/get-products',
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'lcwp_get_products' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/get-product/(?P<id>[\d]+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_product' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-orders',
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'lcwp_get_orders' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/get-order/(?P<id>[\d]+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_order' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-contacts',
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'lcwp_get_contacts' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/get-contact/(?P<id>[\d]+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_contact' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-categories',
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'lcwp_get_categories' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/get-category/(?P<id>[\d]+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_category' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-variations/(?P<product_id>[\d]+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_variations' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-variation/(?P<id>[\d]+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_variation' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-attributes',
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'lcwp_get_attributes' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/get-attribute/(?P<id>[\d]+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_attribute' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-attribute-terms/(?P<id>[\d]+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_attribute_terms' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-attribute-term(?:/(&P<attribute_id>\d+))?(?:/(?P<term_id>\d+))?',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_attribute_term' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-attribute-term-by-name(?:/(&P<term_name>\d+))?(?:/(?P<attribute_slug>\d+))?',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_attribute_term_by_name' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);
			register_rest_route(
				$namespace,
				'/get-tags',
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'lcwp_get_tags' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/get-tag/(?P<id>[\d]+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'lcwp_get_tag' ),
						'permission_callback' => array( $this, 'lcwp_api_permission' ),
						'args'                => array(),
					),
				)
			);

			/**
			 * Post routes
			 */
			register_rest_route(
				$namespace,
				'/upload-image',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_create_image' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/create-category',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_create_category' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/create-product',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_create_product' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/update-product',
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'lcwp_update_product' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/create-tag',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_create_tag' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/update-tag',
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'lcwp_update_tag' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/create-attribute',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_create_attribute' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/create-attribute-term',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_create_attribute_term' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/create-variation',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_create_variation' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/update-variation',
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'lcwp_update_variation' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/create-contact',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_create_contact' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/update-contact',
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'lcwp_update_contact' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/create-order',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_create_order' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/update-order',
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'lcwp_update_order' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/send-last-fetched-time',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'lcwp_store_last_fetched_time' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);

			/**
			 * Delete endpoints
			 */
			register_rest_route(
				$namespace,
				'/delete-product/(?P<id>[\d]+)',
				array(
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'lcwp_delete_product' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/delete-product-variation/(?P<id>[\d]+)',
				array(
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'lcwp_delete_product_variation' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/delete-order/(?P<id>[\d]+)',
				array(
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'lcwp_delete_order' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/delete-contact/(?P<id>[\d]+)',
				array(
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'lcwp_delete_contact' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
			register_rest_route(
				$namespace,
				'/delete-image/(?P<id>[\d]+)',
				array(
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'lcwp_delete_image' ),
					'permission_callback' => array( $this, 'lcwp_api_permission' ),
					'args'                => array(),
				)
			);
		}

		/**
		 * Get a collection of items
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */

		/**
		 * This function validates the api request.
		 */
		public function lcwp_api_permission() {
			$bearer_token = isset( $_SERVER['HTTP_AUTHORIZATION'] ) ? $_SERVER['HTTP_AUTHORIZATION'] : null;
			$token        = null;
			if ( $bearer_token ) {
				$parts = explode( ' ', $bearer_token );
				if ( count( $parts ) === 2 && 'Bearer' === $parts[0] ) {
					$token = $parts[1];
				}
			}

			if ( $token && get_option( 'lcwp_auth_token' ) === $token ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * This function is used to get all products
		 *
		 * @return array of products
		 */
		public function lcwp_get_products() {
			if ( isset( $_GET['page'] ) ) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}

			$all_products = array();
			$products     = get_posts(
				array(
					'posts_per_page' => 100,
					'paged'          => $page,
					'fields'         => 'ids',
					'post_type'      => 'product',
					'post_status'    => 'pending/publish',
				)
			);

			foreach ( $products as $product ) {
				$product = wc_get_product( $product );
				if ( $product->get_name() !== 'AUTO-DRAFT' ) {
					$all_products[] = $this->getProductData( $product );
				}
			}
			return new WP_REST_Response( $all_products, 200 );
		}

		/**
		 * This function is used to get the product data for a specific product
		 *
		 * @param object $product object of a product.
		 * @return array of product data.
		 */
		public function getProductData( $product ) {
			return array(
				'id'                 => $product->get_id(),
				'name'               => $product->get_name(),
				'slug'               => $product->get_slug(),
				'permalink'          => get_permalink( $product->get_id() ),
				'date_created'       => $product->get_date_created(),
				'date_modified'      => $product->get_date_modified(),
				'type'               => $product->get_type(),
				'status'             => $product->get_status(),
				'featured'           => $product->get_featured(),
				'description'        => $product->get_description(),
				'short_description'  => $product->get_short_description(),
				'sku'                => $product->get_sku(),
				'price'              => $product->get_price(),
				'regular_price'      => $product->get_regular_price(),
				'sale_price'         => $product->get_sale_price(),
				'date_on_sale_from'  => $product->get_date_on_sale_from(),
				'date_on_sale_to'    => $product->get_date_on_sale_to(),
				'on_sale'            => $product->is_on_sale(),
				'purchasable'        => $product->is_purchasable(),
				'total_sales'        => $product->get_total_sales(),
				'virtual'            => $product->is_virtual(),
				'downloadable'       => $product->is_downloadable(),
				'downloads'          => $product->get_downloads(),
				'download_limit'     => $product->get_download_limit(),
				'download_expiry'    => $product->get_download_expiry(),
				'tax_status'         => $product->get_tax_status(),
				'tax_class'          => $product->get_tax_class(),
				'manage_stock'       => $product->get_manage_stock(),
				'stock_quantity'     => $product->get_stock_quantity(),
				'stock_status'       => $product->get_stock_status(),
				'back_orders'        => $product->get_backorders(),
				'backorders_allowed' => $product->backorders_allowed(),
				'backordered'        => $product->is_on_backorder(),
				'sold_individually'  => $product->get_sold_individually(),
				'weight'             => $product->get_weight(),
				'dimensions'         => $product->get_dimensions(),
				'shipping_class_id'  => $product->get_shipping_class_id(),
				'upsell_ids'         => $product->get_upsell_ids(),
				'cross_sell_ids'     => $product->get_cross_sell_ids(),
				'parent_id'          => $product->get_parent_id(),
				'purchase_note'      => $product->get_purchase_note(),
				'categories'         => $this->getCategories( $product->get_category_ids() ),
				'tags'               => $product->get_tag_ids(),
				'images'             => $this->getImages( $product ),
				'attributes'         => $this->getAttributes( $product ),
				'default_attributes' => $product->get_default_attributes(),
				'variations'         => $product->get_children(),
			);
		}

		/**
		 * This method is used to get all categories of a product.
		 *
		 * @param array $data array of category ids.
		 * @return array of categories of a product.
		 */
		public function getCategories( $data ) {
			$categories = array();
			if ( null !== $data ) {
				foreach ( $data as $item ) {
					$name         = get_term_by( 'id', $item, 'product_cat' );
					$categories[] = array(
						'id'        => $item,
						'name'      => $name->name,
						'slug'      => null !== get_category( $item ) ? get_category( $item )->slug : null,
						'permalink' => get_category_link( $item ),
					);
				}
			}
			return $categories;
		}

		/**
		 * This method is used to get all images of a product.
		 *
		 * @param object $data object of product images.
		 * @return array of images.
		 */
		public function getImages( $data ) {
			$images = array();
			if ( $data->get_image_id() ) {
				$thumbnail = wp_get_attachment_image_src( $data->get_image_id(), 'single-post-thumbnail' );
				$images[]  = array(
					'id'        => $data->get_image_id(),
					'src'       => $thumbnail[0],
					'thumbnail' => $thumbnail[0],
				);
			}

			if ( $data->get_gallery_image_ids() !== null ) {
				foreach ( $data->get_gallery_image_ids() as $item ) {
					$images[] = array(
						'id'        => $item,
						'src'       => wp_get_attachment_url( $item ),
						'thumbnail' => wp_get_attachment_thumb_url( $item ),
					);
				}
			}
			return $images;
		}

		/**
		 * This function is used to get all attributes of a product.
		 *
		 * @param object $data object of product attributes.
		 * @return array of attributes.
		 */
		public function getAttributes( $data ) {
			$attributes = array();
			if ( null !== $data ) {
				foreach ( $data->get_attributes() as $item ) {
					$attributes[] = array(
						'id'        => $item->get_id(),
						'name'      => $item->get_id() > 0 ? wc_get_attribute( $item->get_id() )->name : $item->get_name(),
						'options'   => $item->get_options(),
						'position'  => $item->get_position(),
						'visible'   => $item->get_visible(),
						'variation' => $item->get_variation(),
					);
				}
			}
			return $attributes;
		}

		/**
		 * This function is used to get an attribute terms.
		 *
		 * @param object $request object of request.
		 * @return array of attribute terms.
		 */
		public function lcwp_get_attribute_terms( $request ) {
			$id        = $request->get_params()['id'];
			$attribute = wc_get_attribute( $id );
			$terms     = get_terms( $attribute->slug, array( 'hide_empty' => false ) );
			$all_terms = array();
			foreach ( $terms as $term ) {
				$all_terms[] = array(
					'id'        => $term->term_id,
					'name'      => $term->name,
					'slug'      => $term->slug,
					'permalink' => get_term_link( $term ),
				);
			}
			return new WP_REST_Response( $all_terms, 200 );
		}

		/**
		 * This function is used to get specific term of an attribute.
		 *
		 * @param object $request object of request.
		 * @return array of attribute terms.
		 */
		public function lcwp_get_attribute_term( $request ) {
			$attribute_id = $request->get_params()['attribute_id'];
			$term_id      = $request->get_params()['term_id'];
			$attribute    = wc_get_attribute( $attribute_id );
			$terms        = get_terms( $attribute->slug, array( 'hide_empty' => false ) );
			$all_terms    = array();
			foreach ( $terms as $term ) {
				$all_terms[ $term->term_id ] = array(
					'id'        => $term->term_id,
					'name'      => $term->name,
					'slug'      => $term->slug,
					'permalink' => get_term_link( $term ),
				);
			}
			if ( count( $all_terms ) > 0 ) {
				if ( isset( $all_terms[ $term_id ] ) ) {
					return new WP_REST_Response( $all_terms[ $term_id ], 200 );
				} else {
					return new WP_Error( 'no_term', 'No term found', array( 'status' => 404 ) );
				}
			} else {
				return new WP_Error( 'no_terms', 'No terms found', array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to get all categories.
		 *
		 * @return array of categories.
		 */
		public function lcwp_get_categories() {
			if ( isset( $_GET['page'] ) ) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}

			$args       = array(
				'taxonomy'   => 'product_cat',
				'number'     => 100,
				'hide_empty' => false,
				'include'    => 'ids',
				'offset'     => ( $page - 1 ) * 100,
			);
			$categories = get_terms( $args );

			$all_categories = array();
			foreach ( $categories as $category ) {
				$all_categories[] = array(
					'id'          => $category->term_id,
					'name'        => $category->name,
					'slug'        => $category->slug,
					'parent'      => $category->parent,
					'description' => $category->description,
					'display'     => $category->display_type,
					'image'       => $this->getCategoryImage( $category->term_id ),
					'menu_order'  => $category->menu_order,
					'count'       => $category->count,
					'_links'      => $this->getCategoryLinks( $category->term_id ),
					'permalink'   => get_category_link( $category->term_id ),
				);
			}
			return new WP_REST_Response( $all_categories, 200 );
		}

		/**
		 * This function is used to get category images.
		 *
		 * @param int $id id of a category.
		 * @return string of category image.
		 */
		public function getCategoryImage( $id ) {
			$thumbnail_id                      = get_term_meta( $id, 'thumbnail_id', true );
			$image                             = wp_get_attachment_url( $thumbnail_id );
			false !== $image ? $image : $image = null;
			return $image;
		}

		/**
		 * This function is used to get category links.
		 *
		 * @param int $id of a category.
		 * @return array of category links.
		 */
		public function getCategoryLinks( $id ) {
			$links = array(
				'self'       => array(
					'href' => rest_url( 'lcwp/v1/categories/' . $id ),
				),
				'collection' => array(
					'href' => rest_url( 'lcwp/v1/categories' ),
				),
			);
			return $links;
		}

		/**
		 * This function is used to get a single category.
		 *
		 * @param object $request of a request.
		 * @return object of a category.
		 */
		public function lcwp_get_category( $request ) {
			$id = $request->get_params();

			if ( $category = get_term_by( 'id', $id['id'], 'product_cat' ) ) {
				$category = $this->getCategoryData( $category );
				return new WP_REST_Response( $category, 200 );
			} else {
				return new WP_Error( 'no_category', 'Category not found', array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to get category data.
		 *
		 * @param object $category object of a category.
		 * @return array of category data.
		 */
		public function getCategoryData( $category ) {
			return array(
				'id'          => $category->term_id,
				'name'        => $category->name,
				'slug'        => $category->slug,
				'parent'      => $category->parent,
				'description' => $category->description,
				'display'     => $category->display_type,
				'image'       => $this->getCategoryImage( $category->term_id ),
				'menu_order'  => $category->menu_order,
				'count'       => $category->count,
				'_links'      => $this->getCategoryLinks( $category->term_id ),
				'permalink'   => get_category_link( $category->term_id ),
			);
		}

		/**
		 * This function is used to get all orders.
		 *
		 * @return array of orders.
		 */
		public function lcwp_get_orders() {
			if ( isset( $_GET['page'] ) ) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}

			$all_orders = array();
			$orders     = get_posts(
				array(
					'posts_per_page' => 100,
					'paged'          => $page,
					'fields'         => 'ids',
					'post_type'      => 'shop_order',
					'post_status'    => 'any',
				)
			);

			foreach ( $orders as $order ) {
				$order = wc_get_order( $order );

				$all_orders[] = $this->getOrderData( $order );
			}
			return new WP_REST_Response( $all_orders, 200 );
		}

		/**
		 * This function is used to get a single order.
		 *
		 * @param object $request of a request.
		 * @return object of an order.
		 */
		public function lcwp_get_order( $request ) {
			$id    = $request->get_params();
			$order = wc_get_order( $id['id'] );

			if ( $order ) {
				return new WP_REST_Response( $this->getOrderData( $order ), 200 );
			} else {
				return new WP_Error( 'no_order', 'Order not found', array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to get a single order data.
		 *
		 * @param object $order object of an order.
		 * @return array of an order data.
		 */
		public function getOrderData( $order ) {
			return array(
				'id'                   => $order->get_id(),
				'parent_id'            => $order->get_parent_id(),
				'order_key'            => $order->get_order_key(),
				'created_via'          => $order->get_created_via(),
				'version'              => $order->get_version(),
				'status'               => $order->get_status(),
				'currency'             => $order->get_currency(),
				'date_created'         => $order->get_date_created(),
				'date_modified'        => $order->get_date_modified(),
				'discount_total'       => $order->get_discount_total(),
				'discount_tax'         => $order->get_discount_tax(),
				'shipping_total'       => $order->get_shipping_total(),
				'shipping_tax'         => $order->get_shipping_tax(),
				'cart_tax'             => $order->get_cart_tax(),
				'total'                => $order->get_total(),
				'total_tax'            => $order->get_total_tax(),
				'prices_include_tax'   => $order->get_prices_include_tax(),
				'customer_id'          => $order->get_customer_id(),
				'customer_ip_address'  => $order->get_customer_ip_address(),
				'customer_user_agent'  => $order->get_customer_user_agent(),
				'customer_note'        => $order->get_customer_note(),
				'billing'              => array(
					'first_name' => $order->get_billing_first_name(),
					'last_name'  => $order->get_billing_last_name(),
					'company'    => $order->get_billing_company(),
					'address_1'  => $order->get_billing_address_1(),
					'address_2'  => $order->get_billing_address_2(),
					'city'       => $order->get_billing_city(),
					'state'      => $order->get_billing_state(),
					'postcode'   => $order->get_billing_postcode(),
					'country'    => $order->get_billing_country(),
				),
				'shipping'             => array(
					'first_name' => $order->get_shipping_first_name(),
					'last_name'  => $order->get_shipping_last_name(),
					'company'    => $order->get_shipping_company(),
					'address_1'  => $order->get_shipping_address_1(),
					'address_2'  => $order->get_shipping_address_2(),
					'city'       => $order->get_shipping_city(),
					'state'      => $order->get_shipping_state(),
					'postcode'   => $order->get_shipping_postcode(),
					'country'    => $order->get_shipping_country(),
				),
				'payment_method'       => $order->get_payment_method(),
				'payment_method_title' => $order->get_payment_method_title(),
				'transaction_id'       => $order->get_transaction_id(),
				'date_paid'            => $order->get_date_paid(),
				'date_completed'       => $order->get_date_completed(),
				'cart_hash'            => $order->get_cart_hash(),
				'meta_data'            => $order->get_meta_data(),
				'line_items'           => $this->getLineItems( $order->get_items() ),
				'tax_lines'            => $this->getTaxLines( $order->get_items( 'tax' ) ),
				'shipping_lines'       => $this->getShippingLines( $order->get_items( 'shipping' ) ),
				'fee_lines'            => $this->getFeeLines( $order->get_items( 'fee' ) ),
				'coupon_lines'         => $this->getCouponLines( $order->get_items( 'coupon' ) ),
				'refunds'              => $this->getRefunds( $order->get_refunds() ),
				'currency_symbol'      => get_woocommerce_currency_symbol( $order->get_currency() ),
				'_links'               => array(
					'self'       => array(
						'href' => rest_url( 'wc/v3/orders/' . $order->get_id() ),
					),
					'collection' => array(
						'href' => rest_url( 'wc/v3/orders' ),
					),
				),
			);
		}

		/**
		 * This function is used to get line items of an order.
		 *
		 * @param array $data array of line items.
		 * @return array of line items.
		 */
		public function getLineItems( $data ) {
			$line_items = array();
			foreach ( $data as $item ) {
				$product = wc_get_product( $item->get_product_id() );

				$line_items[] = array(
					'id'           => $item->get_product_id(),
					'name'         => $item->get_name(),
					'product_id'   => $item->get_product_id(),
					'variation_id' => $item->get_variation_id(),
					'quantity'     => $item->get_quantity(),
					'subtotal'     => $item->get_subtotal(),
					'subtotal_tax' => $item->get_subtotal_tax(),
					'total'        => $item->get_total(),
					'total_tax'    => $item->get_total_tax(),
					'taxes'        => $item->get_taxes(),
					'sku'          => $product->get_sku(),
					'meta_data'    => $item->get_meta_data(),
				);
			}
			return $line_items;
		}

		/**
		 * This function is used to get tax lines of an order.
		 *
		 * @param object $data object of tax lines.
		 * @return array of tax lines.
		 */
		public function getTaxLines( $data ) {
			$tax_lines = array();
			foreach ( $data as $item ) {
				$tax_lines[] = array(
					'id'                 => $item->get_rate_id(),
					'rate_code'          => $item->get_rate_code(),
					'rate_id'            => $item->get_rate_id(),
					'label'              => $item->get_label(),
					'compound'           => $item->get_compound(),
					'tax_total'          => $item->get_tax_total(),
					'shipping_tax_total' => $item->get_shipping_tax_total(),
				);
			}
			return $tax_lines;
		}

		/**
		 * This function is used to get shipping lines of an order.
		 *
		 * @param object $data object of shipping lines.
		 * @return array of shipping lines.
		 */
		public function getShippingLines( $data ) {
			$shipping_lines = array();
			foreach ( $data as $item ) {
				$shipping_lines[] = array(
					'id'           => $item->get_instance_id(),
					'method_id'    => $item->get_method_id(),
					'method_title' => $item->get_method_title(),
					'total'        => $item->get_total(),
					'taxes'        => $item->get_taxes(),
				);
			}
			return $shipping_lines;
		}

		/**
		 * This function is used to get fee lines of an order.
		 *
		 * @param object $data object of fee lines.
		 * @return array of fee lines.
		 */
		public function getFeeLines( $data ) {
			$fee_lines = array();
			foreach ( $data as $item ) {
				$fee_lines[] = array(
					'id'         => $item->get_id(),
					'name'       => $item->get_name(),
					'tax_class'  => $item->get_tax_class(),
					'tax_status' => $item->get_tax_status(),
					'total'      => $item->get_total(),
					'total_tax'  => $item->get_total_tax(),
					'taxes'      => $item->get_taxes(),
				);
			}
			return $fee_lines;
		}

		/**
		 * This function is used to get coupon lines of an order.
		 *
		 * @param object $data object of coupon lines.
		 * @return array of coupon lines.
		 */
		public function getCouponLines( $data ) {
			$coupon_lines = array();
			foreach ( $data as $item ) {
				$coupon_lines[] = array(
					'id'           => $item->get_id(),
					'code'         => $item->get_code(),
					'discount'     => $item->get_discount(),
					'discount_tax' => $item->get_discount_tax(),
				);
			}
			return $coupon_lines;
		}

		/**
		 * This function is used to get refunds data of an order.
		 *
		 * @param object $data object of refunds data.
		 * @return array of refunds data.
		 */
		public function getRefunds( $data ) {
			$refunds = array();
			foreach ( $data as $item ) {
				$refunds[] = array(
					'id'             => $item->get_id(),
					'reason'         => $item->get_reason(),
					'total'          => $item->get_amount(),
					'line_items'     => $this->getLineItems( $item->get_items() ),
					'tax_lines'      => $this->getTaxLines( $item->get_taxes() ),
					'shipping_lines' => $this->getShippingLines( $item->get_shipping_methods() ),
					'fee_lines'      => $this->getFeeLines( $item->get_fees() ),
					'coupon_lines'   => $this->getCouponLines( $item->get_coupons() ),
				);
			}
			return $refunds;
		}

		/**
		 * This function is used to get all customers.
		 *
		 * @return array of customers.
		 */
		public function lcwp_get_contacts() {
			if ( isset( $_GET['page'] ) ) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}

			$all_customers = array();
			$customers     = new WP_User_Query(
				array(
					'fields' => 'ID',
					'role'   => 'customer',
					'number' => 100,
					'paged'  => $page,
				)
			);

			foreach ( $customers->get_results() as $customer ) {
				$customer = new WC_Customer( $customer );

				$all_customers[] = $this->getContactData( $customer );
			}
			return new WP_REST_Response( $all_customers, 200 );
		}

		/**
		 * This function is used to get a single customer data.
		 *
		 * @param object $customer of a single customer.
		 * @return array of a customer data.
		 */
		public function getContactData( $customer ) {
			return array(
				'id'                 => $customer->get_id(),
				'date_created'       => $customer->get_date_created(),
				'date_modified'      => $customer->get_date_modified(),
				'email'              => $customer->get_email(),
				'first_name'         => $customer->get_first_name(),
				'last_name'          => $customer->get_last_name(),
				'role'               => $customer->get_role(),
				'username'           => $customer->get_username(),
				'billing'            => array(
					'first_name' => $customer->get_billing_first_name(),
					'last_name'  => $customer->get_billing_last_name(),
					'company'    => $customer->get_billing_company(),
					'address_1'  => $customer->get_billing_address_1(),
					'address_2'  => $customer->get_billing_address_2(),
					'city'       => $customer->get_billing_city(),
					'state'      => $customer->get_billing_state(),
					'postcode'   => $customer->get_billing_postcode(),
					'country'    => $customer->get_billing_country(),
					'email'      => $customer->get_billing_email(),
					'phone'      => $customer->get_billing_phone(),
				),
				'shipping'           => array(
					'first_name' => $customer->get_shipping_first_name(),
					'last_name'  => $customer->get_shipping_last_name(),
					'company'    => $customer->get_shipping_company(),
					'address_1'  => $customer->get_shipping_address_1(),
					'address_2'  => $customer->get_shipping_address_2(),
					'city'       => $customer->get_shipping_city(),
					'state'      => $customer->get_shipping_state(),
					'postcode'   => $customer->get_shipping_postcode(),
					'country'    => $customer->get_shipping_country(),
				),
				'is_paying_customer' => $customer->is_paying_customer(),
				'avatar_url'         => $customer->get_avatar_url(),
				'meta_data'          => $customer->get_meta_data(),
				'_links'             => array(
					'self'       => array(
						'href' => rest_url( 'wc/v3/customers/' . $customer->get_id() ),
					),
					'collection' => array(
						'href' => rest_url( 'wc/v3/customers' ),
					),
				),
			);
		}

		/**
		 * This function is used to get single customer data.
		 *
		 * @param object $request of a request.
		 * @return object of a customer.
		 */
		public function lcwp_get_contact( $request ) {
			$id       = $request->get_params();
			$customer = new WC_Customer( $id['id'] );

			if ( $customer->get_id() ) {
				return new WP_REST_Response( $this->getContactData( $customer ), 200 );
			} else {
				return new WP_Error( 'no_customer', 'Customer not found', array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to get all variaons of a product.
		 *
		 * @param object $request of a request.
		 * @return array of variations.
		 */
		public function lcwp_get_variations( $request ) {
			$all_variations = array();
			$product_id     = $request->get_params()['product_id'];
			$product        = wc_get_product( $product_id );
			$variations     = $product->get_children();

			foreach ( $variations as $variation ) {
				$data             = new WC_Product_Variation( $variation );
				$all_variations[] = $this->getVariationData( $data );
			}
			return new WP_REST_Response( $all_variations, 200 );
		}

		/**
		 * This function is used to get a single product variation.
		 *
		 * @param object $request of a request.
		 * @return object of a product variation.
		 */
		public function lcwp_get_variation( $request ) {
			$id   = $request->get_params();
			$data = new WC_Product_Variation( $id['id'] );

			if ( get_post_type( $data->get_id() ) === 'product_variation' ) {
				$variation = $this->getVariationData( $data );
				return new WP_REST_Response( $variation, 200 );
			} else {
				return new WP_Error( 'no_product_variation', 'Product variation not found', array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to a get product variation data.
		 *
		 * @param object $data object of a product variation.
		 * @return array of a product variation.
		 */
		public function getVariationData( $data ) {
			return array(
				'parent_id'          => $data->get_parent_id(),
				'id'                 => $data->get_id(),
				'name'               => $data->get_name(),
				'date_created'       => $data->get_date_created(),
				'date_modified'      => $data->get_date_modified(),
				'description'        => $data->get_description(),
				'pemalink'           => $data->get_permalink(),
				'sku'                => $data->get_sku(),
				'price'              => $data->get_price(),
				'regular_price'      => $data->get_regular_price(),
				'sale_price'         => $data->get_sale_price(),
				'date_on_sale_from'  => $data->get_date_on_sale_from(),
				'date_on_sale_to'    => $data->get_date_on_sale_to(),
				'on_sale'            => $data->is_on_sale(),
				'status'             => $data->get_status(),
				'purchasable'        => $data->is_purchasable(),
				'virtual'            => $data->is_virtual(),
				'downloadable'       => $data->is_downloadable(),
				'downloads'          => $data->get_downloads(),
				'download_limit'     => $data->get_download_limit(),
				'download_expiry'    => $data->get_download_expiry(),
				'tax_status'         => $data->get_tax_status(),
				'tax_class'          => $data->get_tax_class(),
				'manage_stock'       => $data->get_manage_stock(),
				'stock_quantity'     => $data->get_stock_quantity(),
				'stock_status'       => $data->get_stock_status(),
				'backorders'         => $data->get_backorders(),
				'backorders_allowed' => $data->backorders_allowed(),
				'backordered'        => $data->is_on_backorder(),
				'weight'             => $data->get_weight(),
				'dimentions'         => $data->get_dimensions(),
				'shipping_class'     => $data->get_shipping_class(),
				'shipping_class_id'  => $data->get_shipping_class_id(),
				'image'              => $data->get_image() !== '' ? array(
					'id'        => $data->get_image_id(),
					'src'       => wp_get_attachment_url( $data->get_image_id() ),
					'thumbnail' => wp_get_attachment_thumb_url( $data->get_image_id() ),
				) : '',
				'attributes'         => $this->getVariationAttribute( $data->get_attributes(), $data->get_parent_id() ),
				'menu_order'         => $data->get_menu_order(),
				'meta_data'          => $data->get_meta_data(),
			);
		}

		/**
		 * This function is used to get variation attributes.
		 *
		 * @param object $data object of a variation attribute.
		 * @param int    $parent_id id of the variation parent.
		 * @return array of product variation attributes.
		 */
		public function getVariationAttribute( $data, $parent_id ) {
			$product    = wc_get_product( $parent_id );
			$product    = $this->getProductData( $product );
			$attributes = array();

			$product_attributes = array();
			foreach ( $product['attributes'] as $attribute ) {
				$product_attributes[ sanitize_title( $attribute['name'] ) ] = array(
					'id'   => $attribute['id'],
					'name' => sanitize_title( $attribute['name'] ),
				);
			}

			foreach ( $data as $key => $item ) {
				$attributes[] = array(
					'id'     => count( $product_attributes ) > 0 && isset( $product_attributes[ $key ] ) &&
						0 === $product_attributes[ $key ]['id'] ?
						$product_attributes[ $key ]['id'] : wc_attribute_taxonomy_id_by_name( $key ),
					'name'   => wc_attribute_label( $key ),
					'option' => $item,
				);
			}
			return $attributes;
		}

		/**
		 * This function is used to get a single product.
		 *
		 * @param object $request object of a request.
		 * @return object of a product.
		 */
		public function lcwp_get_product( $request ) {
			$id      = $request->get_params();
			$product = wc_get_product( $id['id'] );

			if ( $product ) {
				return new WP_REST_Response( $this->getProductData( $product ), 200 );
			} else {
				return new WP_Error( 'no_product', 'Product not found', array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to get get a single attribute.
		 *
		 * @param object $request object of a request.
		 * @return object of an attribute or an array of attributes.
		 */
		public function lcwp_get_attribute( $request ) {
			$id        = $request->get_params();
			$attribute = wc_get_attribute( $id['id'] );

			if ( $attribute ) {
				return new WP_REST_Response( $attribute, 200 );
			} else {
				return new WP_Error( 'no_attribute', 'Attribute not found', array( 'status' => 404 ) );
			}

			$attributes     = wc_get_attribute_taxonomies();
			$all_attributes = array();
			foreach ( $attributes as $attribute ) {
				$all_attributes[] = array(
					'id'           => $attribute->attribute_id,
					'name'         => $attribute->attribute_label,
					'slug'         => $attribute->attribute_name,
					'type'         => $attribute->attribute_type,
					'order_by'     => $attribute->attribute_orderby,
					'has_archives' => $attribute->attribute_public,
				);
			}
			return new WP_REST_Response( $all_attributes, 200 );
		}

		/**
		 * This function is used to get all attributes.
		 *
		 * @return array of attributes.
		 */
		public function lcwp_get_attributes() {
			$attributes     = wc_get_attribute_taxonomies();
			$all_attributes = array();
			foreach ( $attributes as $attribute ) {
				$all_attributes[] = wc_get_attribute( $attribute->attribute_id );
			}
			return new WP_REST_Response( $all_attributes, 200 );
		}

		/**
		 * This function is used to get all tags.
		 *
		 * @return array of tags.
		 */
		public function lcwp_get_tags() {
			$terms      = get_terms( 'product_tag' );
			$term_array = array();
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$term_array[] = array(
						'id'    => $term->term_id,
						'name'  => $term->name,
						'slug'  => $term->slug,
						'count' => $term->count,
					);
				}
			}
			return new WP_REST_Response( $term_array, 200 );
		}

		/**
		 * This function is used to get a single tag.
		 *
		 * @param object $request object of a request.
		 * @return object of a tag.
		 */
		public function lcwp_get_tag( $request ) {
			$id   = $request->get_params();
			$term = get_term( $id['id'], 'product_tag' );

			if ( $term ) {
				return new WP_REST_Response( $term, 200 );
			} else {
				return new WP_Error( 'no_tag', 'Tag not found', array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to create an image.
		 *
		 * @param object $request object of a request.
		 * @return array of an image.
		 */
		public function lcwp_create_image( $request ) {
			try {
				$image      = $request->get_params()['image'];
				$upload_dir = wp_upload_dir();
				$image_data = file_get_contents( $image );

				$filename = $this->generateRandomString() . '.' . pathinfo( $image, PATHINFO_EXTENSION );

				if ( wp_mkdir_p( $upload_dir['path'] ) ) {
					$file = $upload_dir['path'] . '/' . $filename;
				} else {
					$file = $upload_dir['basedir'] . '/' . $filename;
				}

				file_put_contents( $file, $image_data );

				$wp_filetype = wp_check_filetype( $filename, null );
				$attachment  = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title'     => sanitize_file_name( $filename ),
					'post_content'   => '',
					'post_status'    => 'inherit',
				);
				$attach_id   = wp_insert_attachment( $attachment, $file );
				require_once ABSPATH . 'wp-admin/includes/image.php';
				$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
				wp_update_attachment_metadata( $attach_id, $attach_data );

				/**
				 * Get the image by id.
				 */
				$image = wp_get_attachment_image_src( $attach_id, 'full' );
				return new WP_REST_Response(
					array(
						'id'         => $attach_id,
						'source_url' => $image[0],
					),
					200
				);
			} catch ( Exception $e ) {
				return new WP_Error( 'no_image', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to delete an image.
		 *
		 * @param object $request object of a request.
		 * @return array of a message. Message contains either success or error.
		 */
		public function lcwp_delete_image( $request ) {
			$id         = $request->get_params();
			$attachment = get_post( $id['id'] );
			if ( $attachment ) {
				wp_delete_attachment( $id['id'], true );
				return new WP_REST_Response(
					array(
						'deleted' => true,
						'message' => 'Image deleted successfully',
					),
					200
				);
			} else {
				return new WP_Error( 'no_image', 'Image not found', array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to generate a random string. Whihc is unique.
		 *
		 * @param integer $length given length of the random string.
		 * @return string of a random string.
		 */
		public function generateRandomString( $length = 10 ) {
			return substr(
				str_shuffle(
					str_repeat(
						$x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
						ceil( $length / strlen( $x ) )
					)
				),
				1,
				$length
			);
		}

		/**
		 * This function is used to create a category.
		 *
		 * @param object $request object of a request.
		 * @return object of the created category.
		 */
		public function lcwp_create_category( $request ) {
			$data = $request->get_params();
			try {
				$data = wp_insert_term(
					$data['name'],
					'product_cat',
					array(
						'description' => $data['description'],
					)
				);

				$data = json_decode( wp_json_encode( $data ), false );

				if ( isset( $data ) && isset( $data->term_id ) ) {
					if ( isset( $data ) && isset( $data->image ) && null === $data->image ) {
						add_term_meta( $data->term_id, 'thumbnail_id', (int) $data->image );
					}
					$category = get_term_by( 'id', $data->term_id, 'product_cat' );
					return new WP_REST_Response( $this->getCategoryData( $category ), 200 );
				} elseif (
					isset( $data ) &&
					isset( $data->errors ) && isset( $data->errors->term_exists ) &&
					isset( $data->errors->term_exists[0] )
				) {
					return new WP_Error( 'term_exists', $data->errors->term_exists[0], array( 'status' => 404 ) );
				} else {
					return new WP_Error( 'no_category', 'Category not created', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_category', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to create a tag.
		 *
		 * @param object $request object of a request.
		 * @return object of the created tag.
		 */
		public function lcwp_create_tag( $request ) {
			$data = $request->get_params();
			try {
				$data = wp_insert_term( $data['name'], 'product_tag' );

				$data = json_decode( wp_json_encode( $data ), false );

				if ( isset( $data ) && isset( $data->term_id ) ) {
					$tag = get_term_by( 'id', $data->term_id, 'product_tag' );
					return new WP_REST_Response( $tag, 200 );
				} elseif (
					isset( $data ) &&
					isset( $data->errors ) && isset( $data->errors->term_exists ) &&
					isset( $data->errors->term_exists[0] )
				) {
					return new WP_Error( 'term_exists', $data->errors->term_exists[0], array( 'status' => 404 ) );
				} else {
					return new WP_Error( 'no_tag', 'Tag not created', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_tag', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to update a tag.
		 *
		 * @param object $request object of a request.
		 * @return object of the updated tag.
		 */
		public function lcwp_update_tag( $request ) {
			$data = $request->get_params();
			$tag  = wp_update_term(
				$data['id'],
				'product_tag',
				array(
					'name' => $data['name'],
				)
			);
			$tag  = get_term_by( 'id', $data['id'], 'product_tag' );
			return new WP_REST_Response( $tag, 200 );
		}

		/**
		 * This function is used to create an attribute.
		 *
		 * @param object $request object of a request.
		 * @return object of the created attribute.
		 */
		public function lcwp_create_attribute( $request ) {
			$data = $request->get_params();
			try {
				$data = wc_create_attribute(
					array(
						'name'         => $data['name'],
						'slug'         => $data['slug'],
						'type'         => $data['type'],
						'order_by'     => $data['order_by'],
						'has_archives' => $data['has_archives'],
					)
				);

				$data = json_decode( wp_json_encode( $data ), false );

				if ( isset( $data ) && 'integer' === gettype( $data ) ) {
					$attribute = wc_get_attribute( $data );
					return new WP_REST_Response( $attribute, 200 );
				} elseif (
					isset( $data ) &&
					isset( $data->errors ) && isset( $data->errors->invalid_product_attribute_slug_already_exists ) &&
					isset( $data->errors->invalid_product_attribute_slug_already_exists[0] )
				) {
					return new WP_Error(
						'duplicate_attribute',
						$data->errors->invalid_product_attribute_slug_already_exists[0],
						array( 'status' => 404 )
					);
				} else {
					return new WP_Error( 'no_attribute', 'Attribute not created', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_attribute', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to create a product.
		 *
		 * @param object $request of a request.
		 * @return object of the created product.
		 */
		public function lcwp_create_product( $request ) {
			$data = $request->get_params();
			try {
				if ( 'simple' === $data['type'] ) {
					$product = new WC_Product_Simple();
				} else {
					$product = new WC_Product_Variable();
				}
				$product = $this->setProductData( $product, $data );

				$product = wc_get_product( $product->get_id() );

				return new WP_REST_Response( $this->getProductData( $product ), 200 );
			} catch ( Exception $e ) {
				return new WP_Error( 'no_product', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to update a product.
		 *
		 * @param object $request of a request.
		 * @return object of the updated product.
		 */
		public function lcwp_update_product( $request ) {
			try {
				$data = $request->get_params();

				if ( 'simple' === $data['type'] ) {
					$product = new WC_Product_Simple( $data['id'] );
				} else {
					$product = new WC_Product_Variable( $data['id'] );
				}

				if ( false === $product ) {
					return new WP_Error( 'no_product', 'Product not found', array( 'status' => 404 ) );
				} else {
					$product = $this->setProductData( $product, $data );

					$product = wc_get_product( $product->get_id() );
					return new WP_REST_Response( $this->getProductData( $product ), 200 );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_product', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to set the product data.
		 *
		 * @param object $product object of the product.
		 * @param array  $data array of the data to be set.
		 * @return object of the product.
		 */
		public function setProductData( $product, $data ) {
			if ( isset( $data['name'] ) ) {
				$product->set_name( $data['name'] );
			}
			if ( isset( $data['slug'] ) ) {
				$product->set_slug( $data['slug'] );
			}
			if ( isset( $data['status'] ) ) {
				$product->set_status( $data['status'] );
			}
			if ( isset( $data['featured'] ) ) {
				$product->set_featured( $data['featured'] );
			}
			if ( isset( $data['price'] ) ) {
				$product->set_price( $data['price'] );
			}
			if ( isset( $data['regular_price'] ) ) {
				$product->set_regular_price( $data['regular_price'] );
			}
			if ( isset( $data['sale_price'] ) ) {
				$product->set_sale_price( $data['sale_price'] );
			}
			if ( isset( $data['date_on_sale_from'] ) ) {
				$product->set_date_on_sale_from( $data['date_on_sale_from'] );
			}
			if ( isset( $data['date_on_sale_to'] ) ) {
				$product->set_date_on_sale_to( $data['date_on_sale_to'] );
			}
			if ( isset( $data['purchase_note'] ) ) {
				$product->set_purchase_note( $data['purchase_note'] );
			}
			if ( isset( $data['description'] ) ) {
				$product->set_description( $data['description'] );
			}
			if ( isset( $data['short_description'] ) ) {
				$product->set_short_description( $data['short_description'] );
			}
			if ( isset( $data['categories'] ) ) {
				$product->set_category_ids( $data['categories'] );
			}
			if ( isset( $data['thumbnail_image'] ) && isset( $data['thumbnail_image']['id'] ) ) {
				$product->set_image_id( $data['thumbnail_image']['id'] );
			}
			if ( isset( $data['gallery_images'] ) ) {
				$product->set_gallery_image_ids( $data['gallery_images'] );
			}
			if ( isset( $data['tags'] ) ) {
				$product->set_tag_ids( $data['tags'] );
			}
			if ( isset( $data['upsell_ids'] ) ) {
				$product->set_upsell_ids( $data['upsell_ids'] );
			}
			if ( isset( $data['cross_sell_ids'] ) ) {
				$product->set_cross_sell_ids( $data['cross_sell_ids'] );
			}
			if ( isset( $data['stock_status'] ) ) {
				$product->set_stock_status( $data['stock_status'] );
			}
			if ( isset( $data['stock_quantity'] ) ) {
				$product->set_stock_quantity( $data['stock_quantity'] );
			}
			if ( isset( $data['manage_stock'] ) ) {
				$product->set_manage_stock( $data['manage_stock'] );
			}
			$product->save();

			/**
			 * Create attributes.
			 */
			$product_level_attributes = array();

			if ( isset( $data['attributes'] ) && is_array( $data['attributes'] ) && count( $data['attributes'] ) > 0 ) {
				foreach ( $data['attributes'] as $key => $attribute ) {
					if ( $attribute['id'] <= 0 ) {
						$create_attribute = new WC_Product_Attribute();
						$create_attribute->set_id( 0 );
						$create_attribute->set_name( $attribute['name'] );
						$create_attribute->set_options( $attribute['options'] );
						$create_attribute->set_visible( true );
						$create_attribute->set_variation( true );

						$product_level_attributes[] = $create_attribute;
					} else {
						if ( isset( $attribute['name'] ) && isset( $attribute['options'] ) ) {
							/**
							 * Clean attribute name to get the taxonomy.
							 */
							$taxonomy = $attribute['slug'];

							$option_term_ids = array();

							/**
							 * Loop through defined attribute data options (terms values).
							 */
							foreach ( $attribute['options'] as $option ) {
								if ( term_exists( $option, $taxonomy ) ) {
									/**
									 * Save the possible option value for the attribute which will be used for variation later.
									 */
									wp_set_object_terms( $product->id, $option, $taxonomy, true );
									/**
									 * Get the term ID.
									 */
									$option_term_ids[] = get_term_by( 'name', $option, $taxonomy )->term_id;
								}
							}
						}

						$create_attribute = new WC_Product_Attribute();
						$create_attribute->set_id( $attribute['id'] );
						$create_attribute->set_name( $taxonomy );
						$create_attribute->set_options( $option_term_ids );
						$create_attribute->set_visible( true );
						$create_attribute->set_variation( true );

						$product_level_attributes[] = $create_attribute;
					}
				}
			}

			if ( count( $product_level_attributes ) > 0 ) {
				$product->set_attributes( $product_level_attributes );
				$product->save();
			}

			return $product;
		}

		/**
		 * This function is used to create a variation.
		 *
		 * @param object $request object of the request.
		 * @return object of the created variation.
		 */
		public function lcwp_create_variation( $request ) {
			$data = $request->get_params();
			try {
				$variation = new WC_Product_Variation();
				$variation = $this->setVariationData( $variation, $data );

				$variation = new WC_Product_Variation( $variation->get_id() );

				$variation = $this->getVariationData( $variation );
				return new WP_REST_Response( $variation, 200 );
			} catch ( Exception $e ) {
				return new WP_Error( 'no_variation', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to update a variation.
		 *
		 * @param object $request object of the request.
		 * @return object of the updated variation.
		 */
		public function lcwp_update_variation( $request ) {
			try {
				$data      = $request->get_params();
				$variation = new WC_Product_Variation( $data['variation_id'] );

				$variation = $this->setVariationData( $variation, $data );

				$variation = new WC_Product_Variation( $variation->get_id() );

				$variation = $this->getVariationData( $variation );
				return new WP_REST_Response( $variation, 200 );
			} catch ( Exception $e ) {
				return new WP_Error( 'no_variation', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to set the variation data.
		 *
		 * @param object $variation object of the variation.
		 * @param array  $data array of the data to be set.
		 * @return object of the variation.
		 */
		public function setVariationData( $variation, $data ) {
			if ( isset( $data['parent_id'] ) ) {
				$variation->set_parent_id( $data['parent_id'] );
			}
			if ( isset( $data['description'] ) ) {
				$variation->set_description( $data['description'] );
			}
			if ( isset( $data['price'] ) ) {
				$variation->set_price( $data['price'] );
			}
			if ( isset( $data['regular_price'] ) ) {
				$variation->set_regular_price( $data['regular_price'] );
			}
			if ( isset( $data['sale_price'] ) ) {
				$variation->set_sale_price( $data['sale_price'] );
			}
			if ( isset( $data['date_on_sale_from'] ) ) {
				$variation->set_date_on_sale_from( $data['date_on_sale_from'] );
			}
			if ( isset( $data['date_on_sale_to'] ) ) {
				$variation->set_date_on_sale_to( $data['date_on_sale_to'] );
			}
			if ( isset( $data['image'] ) && null !== $data['image'] ) {
				$variation->set_image_id( $data['image'] );
			}
			if ( isset( $data['manage_stock'] ) ) {
				$variation->set_manage_stock( $data['manage_stock'] );
			}
			if ( isset( $data['stock_quantity'] ) ) {
				$variation->set_stock_quantity( $data['stock_quantity'] );
			}
			if ( isset( $data['stock_status'] ) ) {
				$variation->set_stock_status( $data['stock_status'] );
			}
			if (
				isset( $data['attributes'] ) && count( $data['attributes'] ) > 0
			) {
				$variation->set_attributes( $data['attributes'] );
			}

			$variation->save();

			if ( isset( $data['parent_id'] ) ) {
				$product = wc_get_product( $data['parent_id'] );
				$product->save();
			}

			return $variation;
		}

		/**
		 * This function is used to create a customer.
		 *
		 * @param object $request object of the request.
		 * @return object of the created contact.
		 */
		public function lcwp_create_contact( $request ) {
			try {
				$data    = $request->get_params();
				$contact = new WC_Customer();

				$contact = $this->setContactData( $contact, $data );

				if ( $contact->get_id() ) {
					return new WP_REST_Response( $this->getContactData( $contact ), 200 );
				} else {
					return new WP_Error( 'no_contact', 'Contact not created', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_contact', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to update a customer.
		 *
		 * @param object $request object of the request.
		 * @return object of the updated contact.
		 */
		public function lcwp_update_contact( $request ) {
			try {
				$data    = $request->get_params();
				$contact = new WC_Customer( $data['id'] );

				$contact = $this->setContactData( $contact, $data );
				if ( $contact->get_id() ) {
					return new WP_REST_Response( $this->getContactData( $contact ), 200 );
				} else {
					return new WP_Error( 'no_contact', 'Contact not updated', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_contact', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to set the contact data.
		 *
		 * @param object $contact object of the contact.
		 * @param array  $data array of the data to be set.
		 * @return object of the contact.
		 */
		public function setContactData( $contact, $data ) {
			if ( isset( $data['email'] ) ) {
				$contact->set_email( $data['email'] );
			}
			if ( isset( $data['first_name'] ) ) {
				$contact->set_first_name( $data['first_name'] );
			}
			if ( isset( $data['last_name'] ) ) {
				$contact->set_last_name( $data['last_name'] );
			}
			if ( isset( $data['first_name'] ) || isset( $data['last_name'] ) ) {
				$contact->set_display_name( $data['first_name'] . ' ' . $data['last_name'] );
			}
			if ( isset( $data['first_name'] ) || isset( $data['last_name'] ) || isset( $data['display_name'] ) ) {
				if ( null === $data['first_name'] && null === $data['last_name'] && null !== $data['display_name'] ) {
					$contact->set_username( $data['display_name'] );
				} elseif ( null !== $data['first_name'] && null === $data['last_name'] ) {
					$contact->set_username( $data['first_name'] );
				} elseif ( null === $data['first_name'] && null !== $data['last_name'] ) {
					$contact->set_username( $data['last_name'] );
				} elseif ( null !== $data['first_name'] && null !== $data['last_name'] ) {
					$username = $data['first_name'] . ' ' . $data['last_name'];
					$username = str_replace( ' ', '_', $username );
					$contact->set_username( $username );
				}
			}
			if ( isset( $data['billing'] ) && isset( $data['billing']['first_name'] ) ) {
				$contact->set_billing_first_name( $data['billing']['first_name'] );
			}
			if ( isset( $data['billing'] ) && isset( $data['billing']['last_name'] ) ) {
				$contact->set_billing_last_name( $data['billing']['last_name'] );
			}
			if ( isset( $data['billing'] ) && isset( $data['billing']['address'] ) ) {
				$contact->set_billing_address( $data['billing']['address'] );
			}
			if ( isset( $data['billing'] ) && isset( $data['billing']['email'] ) ) {
				$contact->set_billing_email( $data['billing']['email'] );
			}
			if ( isset( $data['billing'] ) && isset( $data['billing']['phone'] ) ) {
				$contact->set_billing_phone( $data['billing']['phone'] );
			}
			$contact->save();

			return $contact;
		}

		/**
		 * This function is used to create a order.
		 *
		 * @param object $request object of the request.
		 * @return object of the created order.
		 */
		public function lcwp_create_order( $request ) {
			try {
				$data  = $request->get_params();
				$order = new WC_Order();

				$order = $this->setOrderData( $order, $data );

				if ( $order->get_id() ) {
					return new WP_REST_Response( $this->getOrderData( $order ), 200 );
				} else {
					return new WP_Error( 'no_order', 'Order not created', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_order', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to update a order.
		 *
		 * @param object $request object of the request.
		 * @return object of the updated order.
		 */
		public function lcwp_update_order( $request ) {
			try {
				$data  = $request->get_params();
				$order = new WC_Order( $data['id'] );

				$order = $this->setOrderData( $order, $data );
				if ( $order->get_id() ) {
					return new WP_REST_Response( $this->getOrderData( $order ), 200 );
				} else {
					return new WP_Error( 'no_order', 'Order not created', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_order', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to set the order data.
		 *
		 * @param object $order object of the order.
		 * @param array  $data array of the data to be set.
		 * @return object of the order.
		 */
		public function setOrderData( $order, $data ) {
			if ( isset( $data['status'] ) ) {
				$order->set_status( $data['status'] );
			}
			if ( isset( $data['currency'] ) ) {
				$order->set_currency( $data['currency'] );
			}
			if ( isset( $data['date_created'] ) ) {
				$order->set_date_created( $data['date_created'] );
			}
			if ( isset( $data['discount_total'] ) ) {
				$order->set_discount_total( $data['discount_total'] );
			}
			if ( isset( $data['shipping_total'] ) ) {
				/**
				 * Remove previous delivery charge starts.
				 */
				foreach ( $order->get_items( 'fee' ) as $item_id => $item ) {
					if ( 'Delivery Charge' === $item->get_name() ) {
						$order->remove_item( $item_id );
					}
				}

				$fee = new WC_Order_Item_Fee();
				$fee->set_name( 'Delivery Charge' );
				$fee->set_amount( $data['shipping_total'] );
				$fee->set_total( $data['shipping_total'] );
				$fee->save();
				$order->add_item( $fee );
			}
			if ( isset( $data['net_total'] ) ) {
				$order->set_total( $data['net_total'] );
			}
			if ( isset( $data['total_tax'] ) ) {
				/**
				 * Remove previous vat/tax starts.
				 */
				foreach ( $order->get_items( 'fee' ) as $item_id => $item ) {
					if ( 'Vat/Tax' === $item->get_name() ) {
						$order->remove_item( $item_id );
					}
				}

				$fee = new WC_Order_Item_Fee();
				$fee->set_name( 'Vat/Tax' );
				$fee->set_amount( $data['total_tax'] );
				$fee->set_total( $data['total_tax'] );
				$fee->save();
				$order->add_item( $fee );
			}
			if ( isset( $data['customer_id'] ) ) {
				$order->set_customer_id( $data['customer_id'] );
			}
			if ( isset( $data['billing_address'] ) ) {
				$order->set_address( $data['billing_address'], 'billing' );
			}
			if ( isset( $data['shipping_address'] ) ) {
				$order->set_address( $data['shipping_address'], 'shipping' );
			}
			if ( isset( $data['line_items'] ) && count( $data['line_items'] ) > 0 ) {
				/**
				 * Delete previous line items starts.
				 */
				foreach ( $order->get_items() as $item ) {
					wc_delete_order_item( $item->get_id() );
				}

				foreach ( $data['line_items'] as $line_item ) {
					$product = wc_get_product(
						isset( $line_item['variation_id'] ) &&
						$line_item['variation_id'] > 0 ? $line_item['variation_id'] : $line_item['product_id']
					);
					$order->add_product( $product, $line_item['quantity'], $line_item );
				}
			}
			$order->save();
			return $order;
		}

		/**
		 * This function is used to delete a product.
		 *
		 * @param object $request object of the request.
		 * @return array of message.
		 */
		public function lcwp_delete_product( $request ) {
			try {
				$data    = $request->get_params();
				$product = wc_get_product( $data['id'] );
				if ( $product && $product->delete( true ) ) {
					return new WP_REST_Response(
						array(
							'deleted' => true,
							'message' => 'Product deleted successfully',
						),
						200
					);
				} else {
					return new WP_Error( 'no_product', 'Product not found', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_product', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to delete a product variation.
		 *
		 * @param object $request object of the request.
		 * @return array of message.
		 */
		public function lcwp_delete_product_variation( $request ) {
			try {
				$data    = $request->get_params();
				$product = wc_get_product( $data['id'] );
				if ( $product && $product->delete( true ) ) {
					return new WP_REST_Response(
						array(
							'deleted' => true,
							'message' => 'Product variation deleted successfully',
						),
						200
					);
				} else {
					return new WP_Error( 'no_product', 'Product variation not found', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_product', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to delete a order.
		 *
		 * @param object $request object of the request.
		 * @return array of message.
		 */
		public function lcwp_delete_order( $request ) {
			try {
				$data  = $request->get_params();
				$order = new WC_Order( $data['id'] );
				if ( $order->delete( true ) ) {
					return new WP_REST_Response(
						array(
							'deleted' => true,
							'message' => 'Order deleted successfully',
						),
						200
					);
				} else {
					return new WP_Error( 'no_order', 'Order not found', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_order', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to delete a customer.
		 *
		 * @param object $request object of the request.
		 * @return array of message.
		 */
		public function lcwp_delete_contact( $request ) {
			try {
				require_once ABSPATH . 'wp-admin/includes/user.php';

				$data     = $request->get_params();
				$customer = get_userdata( $data['id'] );
				if ( $customer && in_array( 'customer', $customer->roles, true ) && wp_delete_user( $customer->ID ) ) {
					return new WP_REST_Response(
						array(
							'deleted' => true,
							'message' => 'Contact deleted successfully',
						),
						200
					);
				} else {
					return new WP_Error( 'no_customer', 'Contact not found', array( 'status' => 404 ) );
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'no_customer', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to create a attribute term.
		 *
		 * @param object $request object of the request.
		 * @return object of the created attribute term.
		 */
		public function lcwp_create_attribute_term( $request ) {
			try {
				$data     = $request->get_params();
				$taxonomy = $data['parent_attribute_slug'];
				if ( ! $term = get_term_by( 'slug', $data['slug'], $taxonomy ) ) {
					$term = wp_insert_term(
						$data['term_name'],
						$taxonomy,
						array(
							'slug' => $data['slug'],
						)
					);
					if ( is_array( $term ) ) {
						$term = get_term_by( 'id', $term['term_id'], $taxonomy );
					}
					if ( $term ) {
						update_term_meta( $term->term_id, 'order', 0 );
					}
				}

				return new WP_REST_Response( $term, 200 );
			} catch ( Exception $e ) {
				return new WP_Error( 'no_attribute', $e->getMessage(), array( 'status' => 404 ) );
			}
		}

		/**
		 * This function is used to get a attribute term by name.
		 *
		 * @param object $request object of the request.
		 * @return object of the attribute term.
		 */
		public function lcwp_get_attribute_term_by_name( $request ) {
			$data = $request->get_params();
			return get_term_by( 'name', $data['term_name'], $data['attribute_slug'] );
		}

		/**
		 * This function is used to store the last fetched time.
		 *
		 * @param object $request object of the request.
		 * @return array of message.
		 */
		public function lcwp_store_last_fetched_time( $request ) {
			$data = $request->get_params();
			if ( get_option( 'lcwp_last_fetched_time' ) ) {
				update_option( 'lcwp_last_fetched_time', $data );
			} else {
				add_option( 'lcwp_last_fetched_time', $data );
			}

			return new WP_REST_Response(
				array(
					'success' => true,
					'message' => 'Last fetched time stored successfully',
				),
				200
			);
		}
	}
}

/**
 * This function is used to initialize the rest api endpoint.
 */
function init_rest_api_endpoint() {
	$endpoint = new Lcwp_api();
	$endpoint->register_routes();
}
add_action( 'rest_api_init', 'init_rest_api_endpoint' );
