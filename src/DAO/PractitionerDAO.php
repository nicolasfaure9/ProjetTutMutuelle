<?php

namespace GSB\DAO;

use GSB\Domain\Practitioner;

class PractitionerDAO extends DAO {

    /**
     * @var \GSB\DAO\PractitionerTypeDAO
     */
    private $practitionerTypeDAO;

    public function setPractitionerTypeDAO($practitionerTypeDAO) {
        $this->practitionerTypeDAO = $practitionerTypeDAO;
    }

    /**
     * Returns the list of all practitioners, sorted by name and first name.
     *
     * @return array The list of all practitioners.
     */
    public function findAll() {
        $sql = "select * from practitioner order by practitioner_name, practitioner_first_name";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $practitioners = array();
        foreach ($result as $row) {
            $practitionerId = $row['practitioner_id'];
            $practitioners[$practitionerId] = $this->buildDomainObject($row);
        }
        return $practitioners;
    }

    /**
     * Returns the list of all practitioners, sorted by name and first name.
     *
     * @return json The list of all practitioners.
     */
    public function findAllJson() {
        $sql = "select * from practitioner order by practitioner_name, practitioner_first_name";
        $result = $this->getDb()->fetchAll($sql);
        return json_encode($result);
    }

    /**
     * Returns the list of all practitioners for a given type, sorted by name and first name.
     *
     * @param integer $typeId The practitioner type id.
     *
     * @return array The list of practitioners.
     */
    public function findAllByType($typeId) {
        $sql = "select * from practitioner where practitioner_type_id=? order by practitioner_name, practitioner_first_name";
        $result = $this->getDb()->fetchAll($sql, array($typeId));

        // Convert query result to an array of domain objects
        $practitioners = array();
        foreach ($result as $row) {
            $practitionerId = $row['practitioner_id'];
            $practitioners[$practitionerId] = $this->buildDomainObject($row);
        }
        return $practitioners;
    }

    /**
     * Returns the list of all practitioners matching a name and/or a city, sorted by name and first name.
     *
     * @param string $name The name.
     * @param string $city The city.
     *
     * @return array The list of practitioners.
     */
    public function findAllByNameAndCity($name, $city) {
        $sql = "select * from practitioner where practitioner_name like ? and practitioner_city like ? 
            order by practitioner_name, practitioner_first_name";
        // If $name and $city are undefined, the SQL query returns all names (%%) and all cities (%%)
        $result = $this->getDb()->fetchAll($sql, array('%' . $name . '%', '%' . $city . '%'));

        // Convert query result to an array of domain objects
        $practitioners = array();
        foreach ($result as $row) {
            $practitionerId = $row['practitioner_id'];
            $practitioners[$practitionerId] = $this->buildDomainObject($row);
        }
        return $practitioners;
    }

    /**
     * Saves a practitioner into the database.
     *
     * @param \Domain\Practitioner $practitioner The practitioner to save
     */
    public function save($practitioner) {
        $new = false;
        $practitionerData = array(
            'practitioner_name' => $practitioner->getName(),
            'practitioner_first_name' => $practitioner->getFirstName(),
            'practitioner_address' => $practitioner->getAddress(),
            'practitioner_zip_code' => $practitioner->getZipCode(),
            'practitioner_city' => $practitioner->getCity(),
            'notoriety_coefficient' => $practitioner->getNotorietyCoefficient(),
            'practitioner_type_id' => $practitioner->getType()->getId(),
        );

        if ($practitioner->getId()) {
            // The visitor has already been saved : update it
            $this->getDb()->update('practitioner', $practitionerData, array('practitioner_id' => $practitioner->getId()));
            $new=true;
        } else {
            // The visitor has never been saved : insert it
            $this->getDb()->insert('practitioner', $practitionerData);
            // Get the id of the newly created visitor and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $practitioner->setId($id);
            $new = true;
        }
        return $new;
    }

    /**
     * Removes a practitioner from the database.
     *
     * @param \Domain\Practitioner $id The id of the practitioner
     */
    public function delete($id) {
        // Delete the user
        $this->getDb()->delete('practitioner', array('practitioner_id' => $id));
    }

    /**
     * Returns the practitioner matching a given id.
     *
     * @param integer $id The practitioner id.
     *
     * @return \GSB\Domain\Practitioner|throws an exception if no practitioner is found.
     */
    public function find($id) {
        $sql = "select * from practitioner where practitioner_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No Practitioner found for id " . $id);
    }

    public function findJson($id) {
        $sql = "select * from practitioner where practitioner_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return json_encode($row);
        else
            throw new \Exception("No Practitioner found for id " . $id);
    }

    /**
     * Creates a Practitioner instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\Practitioner
     */
    protected function buildDomainObject($row) {
        $typeId = $row['practitioner_type_id'];
        $type = $this->practitionerTypeDAO->find($typeId);

        $practitioner = new Practitioner();
        $practitioner->setId($row['practitioner_id']);
        $practitioner->setName($row['practitioner_name']);
        $practitioner->setFirstName($row['practitioner_first_name']);
        $practitioner->setAddress($row['practitioner_address']);
        $practitioner->setZipCode($row['practitioner_zip_code']);
        $practitioner->setCity($row['practitioner_city']);
        $practitioner->setNotorietyCoefficient($row['notoriety_coefficient']);
        $practitioner->setType($type);
        return $practitioner;
    }

}
