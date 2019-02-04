/**
     * @access      public
     * @param       none
     * @author      Bablu <bablu@atilimited.net>
     * @return      Area, Zone & Ship Est. Data
     */
    function ship_by_area_zone(){

        $zone_list = [];
        $zone = $this->utilities->findAllByAttributeWithOrderBy("bn_navyadminhierarchy", array("ADMIN_TYPE" => 1, "ACTIVE_STATUS" => 1), "CODE");
        
        // zone
        foreach ($zone as $key=>$value)
        {
            $area_list = [];

            // $area = $this->utilities->findAllByAttributeWithOrderBy("bn_navyadminhierarchy", array("ADMIN_TYPE" => 2, "ACTIVE_STATUS" => 1), "CODE");
            $area =  $this->db->query("select * from bn_navyadminhierarchy where PARENT_ID = $value->ADMIN_ID and ACTIVE_STATUS = 1 and ADMIN_TYPE = 2 order by CODE asc")->result();

            // area
            foreach ($area as $key2=>$value2)
            {
                $ship_list = [];

               // $ship = $this->utilities->findAllByAttributeWithOrderBy("bn_ship_establishment", array("ACTIVE_STATUS" => 1), "CODE");
                $ship = $row = $this->db->query("select * from bn_ship_establishment where AREA_ID = $value2->ADMIN_ID and ACTIVE_STATUS = 1 order by CODE asc")->result();

                // ship
                foreach ($ship as $key3=>$value3)
                {
                    // ship list
                    if($value3->AREA_ID == $value2->ADMIN_ID)
                    {
                        $dataAttrs['title'] = 'id';
                        $dataAttrs['data'] = $value3->SHIP_ESTABLISHMENTID;
                        $ship_row = array();
                        $ship_row['title'] = $value3->NAME;
                        $ship_row['href'] = "#$key3";
                        $ship_row['dataAttrs'] = [$dataAttrs];
                        $ship_list[] = $ship_row;
                    }
                }

                // area list
                if($value2->PARENT_ID == $value->ADMIN_ID)
                {
                    $area_row = array();
                    $area_row['title'] = $value2->NAME;
                    $area_row['href'] = "#$key2";
                    $area_row['dataAttrs'] = [];
                    $area_row['data'] = $ship_list;
                    $area_list[] = $area_row;
                }
            }

            // zone list
            if(is_object($value))
            {
                $zone_row = array();
                $zone_row['title'] = $value->NAME;
                $zone_row['href'] = "#$key";
                $zone_row['dataAttrs'] = [];
                $zone_row['data'] = $area_list;
                $zone_list[] = $zone_row;
            }

        }

        //$area_list = reset($area_list);
        //die(var_dump($area_list));
        //die(print_r(json_encode($area_list)));

        return json_encode($zone_list);
    }
