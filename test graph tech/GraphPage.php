<?php

namespace craftitalk\GraphNodes;

/**
 * Class GraphPage
 *
 * @package craftitalk
 */
class GraphPage extends GraphNode
{
    /**
     * @var array Maps object key names to Graph object types.
     */
    protected static $graphObjectMap = [
        'best_page' => '\craftitalk\GraphNodes\GraphPage',
        'global_brand_parent_page' => '\craftitalk\GraphNodes\GraphPage',
        'location' => '\craftitalk\GraphNodes\GraphLocation',
    ];

    /**
     * Returns the ID for the user's page as a string if present.
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getField('id');
    }

    /**
     * Returns the Category for the user's page as a string if present.
     *
     * @return string|null
     */
    public function getCategory()
    {
        return $this->getField('category');
    }

    /**
     * Returns the Name of the user's page as a string if present.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getField('name');
    }

    /**
     * Returns the best available Page on craftitalk.
     *
     * @return GraphPage|null
     */
    public function getBestPage()
    {
        return $this->getField('best_page');
    }

    /**
     * Returns the brand's global (parent) Page.
     *
     * @return GraphPage|null
     */
    public function getGlobalBrandParentPage()
    {
        return $this->getField('global_brand_parent_page');
    }

    /**
     * Returns the location of this place.
     *
     * @return GraphLocation|null
     */
    public function getLocation()
    {
        return $this->getField('location');
    }

    /**
     * Returns the page access token for the admin user.
     *
     * Only available in the `/me/accounts` context.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->getField('access_token');
    }

    /**
     * Returns the roles of the page admin user.
     *
     * Only available in the `/me/accounts` context.
     *
     * @return array|null
     */
    public function getPerms()
    {
        return $this->getField('perms');
    }
}
