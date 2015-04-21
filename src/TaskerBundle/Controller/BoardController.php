<?php

namespace TaskerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use TaskerBundle\Entity\Board;
use TaskerBundle\Form\BoardType;

/**
 * Board controller.
 *
 */
class BoardController extends Controller
{

    /**
     * Lists all Board entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $boards = $em->getRepository('TaskerBundle:Board')->findByUser($this->getUser(), array('date' => 'desc'));

        return $this->render('TaskerBundle:Board:index.html.twig', array(
            'boards' => $boards,
        ));
    }
    /**
     * Creates a new Board board.
     *
     */
    public function createAction(Request $request)
    {
        $board = new Board();
        $form = $this->createCreateForm($board);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($board);
            $em->flush();

            return $this->redirect($this->generateUrl('board_show', array('id' => $board->getId())));
        }

        return $this->render('TaskerBundle:Board:new.html.twig', array(
            'board' => $board,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Board board.
     *
     * @param Board $board The board
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Board $board)
    {
        $form = $this->createForm(new BoardType(), $board, array(
            'action' => $this->generateUrl('board_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Board board.
     *
     */
    public function newAction()
    {
        $board = new Board();
        $form   = $this->createCreateForm($board);

        return $this->render('TaskerBundle:Board:new.html.twig', array(
            'board' => $board,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Board board.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $board = $em->getRepository('TaskerBundle:Board')->find($id);

        if (!$board) {
            throw $this->createNotFoundException('Unable to find Board board.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TaskerBundle:Board:show.html.twig', array(
            'board'      => $board,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Board board.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $board = $em->getRepository('TaskerBundle:Board')->find($id);

        if (!$board) {
            throw $this->createNotFoundException('Unable to find Board board.');
        }

        $editForm = $this->createEditForm($board);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TaskerBundle:Board:edit.html.twig', array(
            'board'      => $board,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Board board.
    *
    * @param Board $board The board
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Board $board)
    {
        $form = $this->createForm(new BoardType(), $board, array(
            'action' => $this->generateUrl('board_update', array('id' => $board->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Board board.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $board = $em->getRepository('TaskerBundle:Board')->find($id);

        if (!$board) {
            throw $this->createNotFoundException('Unable to find Board board.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($board);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('board_edit', array('id' => $id)));
        }

        return $this->render('TaskerBundle:Board:edit.html.twig', array(
            'board'      => $board,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Board board.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $board = $em->getRepository('TaskerBundle:Board')->find($id);

            if (!$board) {
                throw $this->createNotFoundException('Unable to find Board board.');
            }

            $em->remove($board);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('board'));
    }

    /**
     * Creates a form to delete a Board board by id.
     *
     * @param mixed $id The board id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('board_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
