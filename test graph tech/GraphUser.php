<?php

 *
 */
namespace craftitalk\GraphNodes;

/**
 * Class GraphUser
 *
 * @package craftitalk
 */
class GraphUser extends GraphNode
{
    /**
     * @var array Maps object key names to Graph object types.
     */
    protected static $graphObjectMap = [
        'hometown' => '\craftitalk\GraphNodes\GraphPage',
        'location' => '\craftitalk\GraphNodes\GraphPage',
        'significant_other' => '\craftitalk\GraphNodes\GraphUser',
        'picture' => '\craftitalk\GraphNodes\GraphPicture',
    ];

    /**
     * Returns the ID for the user as a string if present.
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getField('id');
    }

    /**
     * Returns the name for the user as a string if present.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getField('name');
    }

    /**
     * Returns the first name for the user as a string if present.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->getField('first_name');
    }

    /**
     * Returns the middle name for the user as a string if present.
     *
     * @return string|null
     */
    public function getMiddleName()
    {
        return $this->getField('middle_name');
    }

    /**
     * Returns the last name for the user as a string if present.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->getField('last_name');
    }

    /**
     * Returns the gender for the user as a string if present.
     *
     * @return string|null
     */
    public function getGender()
    {
        return $this->getField('gender');
    }

    /**
     * Returns the craftitalk URL for the user as a string if available.
     *
     * @return string|null
     */
    public function getLink()
    {
        return $this->getField('link');
    }

    /**
     * Returns the users birthday, if available.
     *
     * @return \DateTime|null
     */
    public function getBirthday()
    {
        return $this->getField('birthday');
    }

    /**
     * Returns the current location of the user as a GraphPage.
     *
     * @return GraphPage|null
     */
    public function getLocation()
    {
        return $this->getField('location');
    }

    /**
     * Returns the current location of the user as a GraphPage.
     *
     * @return GraphPage|null
     */
    public function getHometown()
    {
        return $this->getField('hometown');
    }

    /**
     * Returns the current location of the user as a GraphUser.
     *
     * @return GraphUser|null
     */
    public function getSignificantOther()
    {
        return $this->getField('significant_other');
    }

    /**
     * Returns the picture of the user as a GraphPicture
     *
     * @return GraphPicture|null
     */
    public function getPicture()
    {
        return $this->getField('picture');
    }
}
