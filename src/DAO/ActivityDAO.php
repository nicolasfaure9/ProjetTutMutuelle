<?php

namespace GSB\DAO;

use GSB\Domain\Activity;

class ActivityDAO extends DAO
{
    /**
     * Returns the list of all activities, sorted by trade name.
     *
     * @return array The list of all activities.
     */
    public function findAll() {
        $sql = "select * from activity order by activity_place";
        $result = $this->getDb()->fetchAll($sql);
        
        // Converts query result to an array of domain objects
        $activities = array();
        foreach ($result as $row) {
            $activityId = $row['activity_id'];
            $activities[$activityId] = $this->buildDomainObject($row);
        }
        return $activities;
    }
    
    

//get all activities by one practitioner    
public function findAllByPractitioner($practID) {
        $sql = "select * from activity where activity_id 
               in (select activity_id from inviting where practitioner_id =?)";
                  
        
        $result = $this->getDb()->fetchAll($sql, array($practID));
        
        // Convert query result to an array of domain objects
        $activities = array();
        foreach ($result as $row) {
            $activityId = $row['activity_id'];
            $activities[$activityId] = $this->buildDomainObject($row);
        }
        return $activities;
    }
    //get all activities by the visitor selected
    public function findAllByVisitor($visitorID) {
        $sql = "select * from activity where activity_id 
               in (select activity_id from organizing where visitor_id =?)";
                  
        
        $result = $this->getDb()->fetchAll($sql, array($visitorID));
        
        // Convert query result to an array of domain objects
        $activities = array();
        foreach ($result as $row) {
            $activityId = $row['activity_id'];
            $activities[$activityId] = $this->buildDomainObject($row);
        }
        return $activities;
    }
    
    //get all activities 
    public function findAllByThemeDate($theme,$dateDeb,$dateFin) {
        
        if ($theme =="")
        {
            if ($dateDeb!="" && $dateFin!="")  
            {
            $sql = "select * from activity where activity_date between ? and ? ";
          
            $result = $this->getDb()->fetchAll($sql, array($dateDeb, $dateFin));
            }
            elseif ($dateDeb=="" && $dateFin!="")
            {
                $sql = "select * from activity where activity_date < ? ";
                
                $result = $this->getDb()->fetchAll($sql, array( $dateFin));
            }
            else 
            {
                 $sql = "select * from activity where activity_date > ? ";
                
                $result = $this->getDb()->fetchAll($sql, array( $dateDeb));
            }
        }
        else
        {
            if ($dateDeb!="" && $dateFin!="")  
            {
            $sql = "select * from activity where activity_theme like ? and activity_date between ? and ? ";
            
            $result = $this->getDb()->fetchAll($sql, array('%' . $theme . '%',$dateDeb, $dateFin));
            }
            elseif ($dateDeb=="" && $dateFin!="")
            {
                $sql = "select * from activity where activity_theme like ? and activity_date < ? ";
                
                $result = $this->getDb()->fetchAll($sql, array('%' . $theme . '%', $dateFin));
            }
            else 
            {
                 $sql = "select * from activity where activity_theme like ? and activity_date > ? ";
               
                $result = $this->getDb()->fetchAll($sql, array('%' . $theme . '%', $dateDeb));
            }
        }
    
        // Convert query result to an array of domain objects
        $activities = array();
        foreach ($result as $row) {
            $activityId = $row['activity_id'];
            $activities[$activityId] = $this->buildDomainObject($row);
        }
        return $activities;
    }
    
    /**
     * Returns the activity matching a given id.
     *
     * @param integer $id The activity id.
     *
     * @return \GSB\Domain\activity|throws an exception if no activity is found.
     */
    public function find($id) {
        $sql = "select * from activity where activity_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No Activity found for id " . $id);
    }

    /**
     * Creates a activity instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\activity
     */
    protected function buildDomainObject($row) {
        $activity = new Activity();
        $activity->setId($row['activity_id']);
        $activity->setDate(new \DateTime($row['activity_date']));
        $activity->setPlace($row['activity_place']);
        $activity->setTheme($row['activity_theme']);
        $activity->setPurpose($row['activity_purpose']);
        return $activity;
    }
    public function save(\GSB\Domain\Activity $type) {
        $activityData = array(
            'activity_id' => $type->getId(),
            'activity_date' => $type->getDate()->format('Y-m-d'),
             'activity_place' => $type->getPlace(),
             'activity_theme' => $type->getTheme(),
             'activity_purpose' => $type->getPurpose(),
        );
        if ($type->getId()) {
            // The user has already been saved : update it
            $this->getDb()->update('activity', $activityData, array('activity_id' => $type->getId()));
        } else {
            $this->getDb()->insert('activity', $activityData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $type->setId($id);
        }
    }
}
