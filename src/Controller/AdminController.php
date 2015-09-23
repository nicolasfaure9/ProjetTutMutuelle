<?php

namespace GSB\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use GSB\Form\Type\PractitionerType;
use GSB\Form\Type\PractitionerTypeType;
use Symfony\Component\HttpFoundation\Response;

class AdminController {

    public function indexAction(Application $app, Request $request) {
        $types = $app['dao.practitionertype']->findAll();
        $arrayType = array();
        $practitioner = new \GSB\Domain\Practitioner();
        $practitionerType = new \GSB\Domain\PractitionerType();
        foreach ($types as $type) {
            array_push($arrayType, $type->getName());
        }
        $editForm = $app['form.factory']->create(new PractitionerType($arrayType), $practitioner);
        $editTypeForm = $app['form.factory']->create(new PractitionerTypeType(), $practitionerType);
        $editTypeForm->bind($request);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $req = $request->request->get('form_practitioner');
            $practitioner = $app['dao.practitioner']->find($req['id']);
            //$practitioner->setId($req['id']);
            $practitioner->setType($app['dao.practitionertype']->find($req['type'] + 1));
            if ($app['dao.practitioner']->save($practitioner))
                $app['session']->getFlashBag()->add('success', 'Le praticien a été ajouté avec succès.');
            else
                $app['session']->getFlashBag()->add('success', 'Le praticien a été modifié avec succès.');
        }
        if ($editTypeForm->isValid()) {
            $req = $request->request->get('form_practitionerType');
            $practitionerType->setId($req['id']);
            if ($app['dao.practitionertype']->save($practitionerType))
                $app['session']->getFlashBag()->add('success', 'Le type de praticien a été ajouté avec succès.');
            else
                $app['session']->getFlashBag()->add('success', 'Le type de praticien a été modifié avec succès.');
        }

        $practitioners = $app['dao.practitioner']->findAll();
        return $app['twig']->render('admin.html.twig', array('practitioners' => $practitioners));
    }

    public function deletePractitionerAction($id, Request $request, Application $app) {
        $app['dao.practitioner']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le praticien a été supprimé avec succès.');
        return $app->redirect($app->url('admin'));
    }

    public function editPractitionerAction(Application $app, Request $request) {
        $id = $request->query->get('id');
        $practitioner = $app['dao.practitioner']->find($id);
        $types = $app['dao.practitionertype']->findAll();
        $arrayType = array();
        foreach ($types as $type) {
            //array_push($arrayType, $type->getName());
            $arrayType[$type->getId() - 1] = $type->getName();
        }
        $editForm = $app['form.factory']->create(new PractitionerType($arrayType), $practitioner);
        $editFormView = $editForm->createView();
        return $app['twig']->render('editForm.html.twig', array('editForm' => $editFormView, 'type' => 'Modification de Monsieur'));
    }

    public function editPractitionerTypeAction(Application $app, Request $request) {
        $id = $request->query->get('id');
        $practitionerType = $app['dao.practitionertype']->find($id);
        $editForm = $app['form.factory']->create(new PractitionerTypeType(), $practitionerType);
        $editFormView = $editForm->createView();
        return $app['twig']->render('editTypeForm.html.twig', array('editForm' => $editFormView, 'type' => 'Modification du type de praticien : '));
    }

    public function getAllErrors($children, $template = true) {
        $this->getAllFormErrors($children);
        return $this->allErrors;
    }

    private function getAllFormErrors($children, $template = true) {
        foreach ($children as $child) {
            if ($child->hasErrors()) {
                $vars = $child->createView()->getVars();
                $errors = $child->getErrors();
                foreach ($errors as $error) {
                    $this->allErrors[$vars["name"]][] = $this->convertFormErrorObjToString($error);
                }
            }

            if ($child->hasChildren()) {
                $this->getAllErrors($child);
            }
        }
    }

    private function convertFormErrorObjToString($error) {
        $errorMessageTemplate = $error->getMessageTemplate();
        foreach ($error->getMessageParameters() as $key => $value) {
            $errorMessageTemplate = str_replace($key, $value, $errorMessageTemplate);
        }
        return $errorMessageTemplate;
    }

    public function addPractitionerAction(Application $app, Request $request) {
        $practitioner = new \GSB\Domain\Practitioner();
        $types = $app['dao.practitionertype']->findAll();
        $arrayType = array();
        foreach ($types as $type) {
            array_push($arrayType, $type->getName());
        }
        $editForm = $app['form.factory']->create(new PractitionerType($arrayType), $practitioner);
        $editFormView = $editForm->createView();
        return $app['twig']->render('editForm.html.twig', array('editForm' => $editFormView, 'type' => 'Ajout d\'un nouveau praticien'));
    }

    public function addPractitionerTypeAction(Application $app, Request $request) {
        $practitionerType = new \GSB\Domain\PractitionerType();
        $editForm = $app['form.factory']->create(new PractitionerTypeType(), $practitionerType);
        $editFormView = $editForm->createView();
        return $app['twig']->render('editTypeForm.html.twig', array('editForm' => $editFormView, 'type' => 'Ajout d\'un nouveau type de praticien'));
    }

}
