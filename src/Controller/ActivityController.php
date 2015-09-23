<?php

namespace GSB\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ActivityController {

    /**
     * Activity details controller.
     *
     * @param integer $id Activity id
     * @param Application $app Silex application
     */
    public function activityDetailsAction($id, Application $app) {
        $activity = $app['dao.activity']->find($id);
        return $app['twig']->render('activity.html.twig', array('activity' => $activity));
    }

    /**
     * activitys controller.
     *
     * @param Application $app Silex application
     */
    public function activitiesAction(Application $app) {
        $activities = $app['dao.activity']->findAll();
        return $app['twig']->render('activities.html.twig', array('activities' => $activities));
    }

    public function activitySearchAction(Application $app) {
        $practitioners = $app['dao.practitioner']->findAll();
        $visitors = $app['dao.visitor']->findAll();
        $themes = $app['dao.theme']->findAll();
        return $app['twig']->render('activities_search.html.twig', array('practitioners' => $practitioners,
                    'visitors' => $visitors,
                    'themes' => $themes));
    }

    public function activityEdit(Request $request, Application $app) {
        $activity = new \GSB\Domain\Activity();
        $activityForm = $app['form.factory']->create(new \GSB\Form\Type\ActivityType(), $activity);
        $activityForm->handleRequest($request);
        if ($activityForm->isValid()) {
            $app['dao.activity']->save($activity);
            return $app->redirect('/activities/') ;
        }
        return $app['twig']->render('activityForm.html.twig', array(
                    'activityForm' => $activityForm->createView()));
    }

    public function activityUpdate($id,Request $request, Application $app) {
        $activity = $app['dao.activity']->find($id);
        $activityForm = $app['form.factory']->create(new \GSB\Form\Type\ActivityType(), $activity);
        $activityForm->handleRequest($request);
        if ($activityForm->isValid()) {

            $app['dao.activity']->save($activity);
            return $app->redirect('/activities/') ;
        }
        return $app['twig']->render('activityForm.html.twig', array(
                    'title' => 'Edit user',
                    'activityForm' => $activityForm->createView()));
    }
    /**
     * Activities search results controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function activityResultsAction(Request $request, Application $app) {
        if ($request->request->has('pract')) {
            // Simple search by practitioner
            $practitionerId = $request->request->get('pract');
            $activities = $app['dao.activity']->findAllByPractitioner($practitionerId);
        } else if ($request->request->has('visi')) {
            /// Simple search by visitor
            $visitorId = $request->request->get('visi');
            $activities = $app['dao.activity']->findAllByVisitor($visitorId);
        } else {
            //Search by theme and date
            $theme = $request->request->get('theme');
            $dateStart = $request->request->get('dateStart');
            $dateEnd = $request->request->get('dateEnd');
            $activities = $app['dao.activity']->findAllByThemeDate($theme, $dateStart, $dateEnd);
        }

        return $app['twig']->render('activities_results.html.twig', array('activities' => $activities));
    }
}
