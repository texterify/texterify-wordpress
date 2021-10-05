<?php

class Texterify_REST_Controller extends WP_REST_Controller {

  /**
   * Register the routes for the objects of the controller.
   */
  public function register_routes() {
    $version = '1';
    $namespace = 'texterify/v' . $version;

    register_rest_route($namespace, '/linked-posts/(?P<id>[\d]+)', array(
      array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => array($this, 'get_linked_posts'),
        'permission_callback' => function () {
          return current_user_can('edit_others_posts');
        },
        'args' => array(
          'id' => array(
            'validate_callback' => function($param, $request, $key) {
              return is_numeric($param);
            }
          )
        )
      )
    ));

    register_rest_route($namespace, '/default-language', array(
      array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => array($this, 'get_default_language'),
        'permission_callback' => function () {
          return current_user_can('edit_others_posts');
        },
        'args' => array(
          'id' => array(
            'validate_callback' => function($param, $request, $key) {
              return is_numeric($param);
            }
          )
        )
      )
    ));

    register_rest_route($namespace, '/posts/(?P<id>[\d]+)/set-language', array(
      array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => array($this, 'set_language'),
        'permission_callback' => function () {
          return current_user_can('edit_others_posts');
        },
        'args' => array(
          'id' => array(
            'validate_callback' => function($param, $request, $key) {
              return is_numeric($param);
            }
          ),
          'post_to_link_to_id' => array(
            'validate_callback' => function($param, $request, $key) {
              return is_numeric($param);
            }
          ),
          'language_code' => array(
            'validate_callback' => function($param, $request, $key) {
              return is_string($param);
            }
          )
        )
      )
    ));

    // register_rest_route($namespace, '/schema', array(
    //   'methods' => WP_REST_Server::READABLE,
    //   'callback' => array($this, 'get_public_item_schema'),
    // ));
  }

  /**
   * Get the linked posts for a given post ID.
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function get_linked_posts($request) {
    $post_id = $request['id'];
    $data = pll_get_post_translations($post_id);

    return new WP_REST_Response($data, 200);
  }

  /**
   * Returns the default language.
   *
   * @return WP_Error|WP_REST_Response
   */
  public function get_default_language() {
    $default_language_slug = pll_default_language();
    $languages = pll_languages_list(array('fields' => NULL));

    for ($i = 0; $i < count($languages); $i++) {
      $language = $languages[$i];

      if ($language->slug == $default_language_slug) {
        $default_language = $language;
        break;
      }
    }

    return new WP_REST_Response($default_language, 200);
  }

  /**
   * Sets the language of a post and links it to other posts.
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function set_language($request) {
    $post_id = $request['id'];

    # Set the language of the post.
    $language_code = $request['language_code'];
    pll_set_post_language($post_id, $language_code);

    # Link the posts together.
    $post_to_link_to_id = $request['post_to_link_to_id'];
    if (!empty($post_to_link_to_id)) {
      $linked_posts = pll_get_post_translations($post_to_link_to_id);
      $linked_posts[$language_code] = $post_id;
      pll_save_post_translations($linked_posts);
    }

    return new WP_REST_Response(["success" => $linked_posts], 200);
  }
}
