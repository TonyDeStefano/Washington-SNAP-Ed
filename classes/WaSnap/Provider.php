<?php

namespace WaSnap;

class Provider {

    private $id;
    private $username;
    private $first_name;
    private $last_name;
    private $agency;
    private $address;
    private $address2;
    private $city;
    private $state;
    private $zip;
    private $email;
    private $phone;
    private $url;
    private $region;
    private $snap_ed_role;
    private $program_focus;
    private $receives_notifications = FALSE;
    private $is_in_provider_directory = FALSE;
    private $is_profile_private = FALSE;
    private $approved_at;
    private $is_provider = FALSE;

    /**
     * Provider constructor.
     *
     * @param null $id
     */
    public function __construct( $id = NULL )
    {
        $this
            ->setId( $id )
            ->read();
    }

    public function read()
    {
        if ( $this->id !== NULL )
        {
            if ( $user = get_user_by( 'ID', $this->id ) )
            {
                $this
                    ->setId( $user->ID )
                    ->setUsername( $user->user_login )
                    ->setFirstName( $user->user_firstname )
                    ->setLastName( $user->user_lastname )
                    ->setEmail( $user->user_email )
                    ->setUrl( $user->user_url )
                    ->setAgency( get_user_meta( $user->ID, 'agency', TRUE ) )
                    ->setAddress( get_user_meta( $user->ID, 'address', TRUE ) )
                    ->setAddress2( get_user_meta( $user->ID, 'address2', TRUE ) )
                    ->setCity( get_user_meta( $user->ID, 'city', TRUE ) )
                    ->setState( get_user_meta( $user->ID, 'state', TRUE ) )
                    ->setZip( get_user_meta( $user->ID, 'zip', TRUE ) )
                    ->setPhone( get_user_meta( $user->ID, 'phone', TRUE ) )
                    ->setRegion( get_user_meta( $user->ID, 'region', TRUE ) )
                    ->setSnapEdRole( get_user_meta( $user->ID, 'snap_ed_role', TRUE ) )
                    ->setProgramFocus( get_user_meta( $user->ID, 'program_focus', TRUE ) )
                    ->setReceivesNotifications( get_user_meta( $user->ID, 'receives_notifications', TRUE ) )
                    ->setIsInProviderDirectory( get_user_meta( $user->ID, 'is_in_provider_directory', TRUE ) )
                    ->setIsProfilePrivate( get_user_meta( $user->ID, 'is_profile_private', TRUE ) )
                    ->setApprovedAt( get_user_meta( $user->ID, 'approved_at', TRUE ) );

                foreach ( $user->roles as $role )
                {
                    if ( $role == 'provider' )
                    {
                        $this->setIsProvider( TRUE );
                        break;
                    }
                }
            }
            else
            {
                $this->setId( NULL );
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Provider
     */
    public function setId( $id )
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return Util::getString( $this->username );
    }

    /**
     * @param mixed $username
     *
     * @return Provider
     */
    public function setUsername( $username )
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return Util::getString( $this->first_name );
    }

    /**
     * @param mixed $first_name
     *
     * @return Provider
     */
    public function setFirstName( $first_name )
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return Util::getString( $this->last_name );
    }

    /**
     * @param mixed $last_name
     *
     * @return Provider
     */
    public function setLastName( $last_name )
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @return mixed
     */
    public function getAgency()
    {
        return Util::getString( $this->agency );
    }

    /**
     * @param mixed $agency
     *
     * @return Provider
     */
    public function setAgency( $agency )
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return Util::getString( $this->address );
    }

    /**
     * @param mixed $address
     *
     * @return Provider
     */
    public function setAddress( $address )
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return Util::getString( $this->address2 );
    }

    /**
     * @param mixed $address2
     *
     * @return Provider
     */
    public function setAddress2( $address2 )
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return Util::getString( $this->city );
    }

    /**
     * @param mixed $city
     *
     * @return Provider
     */
    public function setCity( $city )
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return Util::getString( $this->state );
    }

    /**
     * @param mixed $state
     *
     * @return Provider
     */
    public function setState( $state )
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return Util::getString( $this->zip );
    }

    /**
     * @param mixed $zip
     *
     * @return Provider
     */
    public function setZip( $zip )
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return Util::getString( $this->email );
    }

    /**
     * @param mixed $email
     *
     * @return Provider
     */
    public function setEmail( $email )
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return Util::getString( $this->phone );
    }

    /**
     * @param mixed $phone
     *
     * @return Provider
     */
    public function setPhone( $phone )
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param bool $with_link
     *
     * @return string
     */
    public function getUrl( $with_link = FALSE )
    {
        $url = Util::getUrl( $this->url );

        if ( $with_link && strlen( $url ) > 0 )
        {
            return '<a href="' . $url . '">' . $url . '</a>';
        }

        return $url;
    }

    /**
     * @param mixed $url
     *
     * @return Provider
     */
    public function setUrl( $url )
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return Util::getString( $this->region );
    }

    /**
     * @param mixed $region
     *
     * @return Provider
     */
    public function setRegion( $region )
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSnapEdRole()
    {
        return Util::getString( $this->snap_ed_role );
    }

    /**
     * @param mixed $snap_ed_role
     *
     * @return Provider
     */
    public function setSnapEdRole( $snap_ed_role )
    {
        $this->snap_ed_role = $snap_ed_role;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProgramFocus()
    {
        return Util::getString( $this->program_focus );
    }

    /**
     * @param mixed $program_focus
     *
     * @return Provider
     */
    public function setProgramFocus( $program_focus )
    {
        $this->program_focus = $program_focus;

        return $this;
    }

    /**
     * @return bool
     */
    public function receivesNotifications()
    {
        return Util::getBool( $this->receives_notifications );
    }

    /**
     * @param bool $receives_notifications
     *
     * @return Provider
     */
    public function setReceivesNotifications( $receives_notifications )
    {
        $this->receives_notifications = Util::setBool( $receives_notifications );

        return $this;
    }

    /**
     * @return bool
     */
    public function isInProviderDirectory()
    {
        return Util::getBool( $this->is_in_provider_directory );
    }

    /**
     * @param bool $is_in_provider_directory
     *
     * @return Provider
     */
    public function setIsInProviderDirectory( $is_in_provider_directory )
    {
        $this->is_in_provider_directory = Util::setBool( $is_in_provider_directory );

        return $this;
    }

    /**
     * @return bool
     */
    public function isProfilePrivate()
    {
        return Util::getBool( $this->is_profile_private );
    }

    /**
     * @param bool $is_profile_private
     *
     * @return Provider
     */
    public function setIsProfilePrivate( $is_profile_private )
    {
        $this->is_profile_private = Util::setBool( $is_profile_private );

        return $this;
    }

    /**
     * @param string $format
     *
     * @return false|string
     */
    public function getApprovedAt( $format = 'Y-m-d H:i:s' )
    {
        return Util::getDate( $this->approved_at, $format );
    }

    /**
     * @param mixed $approved_at
     *
     * @return Provider
     */
    public function setApprovedAt( $approved_at )
    {
        $this->approved_at = Util::setDate( $approved_at );

        return $this;
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return ( strlen( $this->getApprovedAt() ) != 0 );
    }

    /**
     * @return bool
     */
    public function isProvider()
    {
        return $this->is_provider;
    }

    /**
     * @param bool $is_provider
     *
     * @return Provider
     */
    public function setIsProvider( $is_provider )
    {
        $this->is_provider = $is_provider;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressHtml()
    {
        $address = [];

        if ( strlen( $this->getAddress() ) > 0 )
        {
            $address[] = $this->getAddress();
        }

        if ( strlen( $this->getAddress2() ) > 0 )
        {
            $address[] = $this->getAddress2();
        }

        if ( strlen( $this->getCity() ) > 0 && strlen( $this->getState() ) > 0 )
        {
            $address[] = trim( $this->getCity() . ', ' . $this->getState() . ' ' . $this->getZip() );
        }
        elseif ( strlen( $this->getCity() . $this->getState() . $this->getZip() ) > 0 )
        {
            $address[] = trim( $this->getCity() . ' ' . $this->getState() . ' ' . $this->getZip() );
        }

        return implode( '<br>', $address );
    }

    public function approve()
    {
        $this->setApprovedAt( time() );
        update_user_meta( $this->id, 'approved_at', $this->getApprovedAt( 'Y-m-d H:i:s' ) );
    }
}