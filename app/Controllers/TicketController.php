<?php

namespace App\Controllers;

use App\Models\Ticket;

/**
 * // --- Destek talebi yönetimi
 */
class TicketController extends BaseController
{
    private Ticket $tickets;

    public function __construct()
    {
        parent::__construct();
        $this->tickets = new Ticket();
    }

    /**
     * // --- Talep listesi
     * @return void
     */
    public function index(): void
    {
        $userId = (int) $this->session->get('user_id', 0);
        if ($userId === 0) {
            $this->response->redirect('/login');
            return;
        }

        $items = $this->tickets->where(['user_id' => $userId]);
        $this->render('tickets/index', [
            'title' => 'Destek Taleplerim',
            'tickets' => $items,
        ]);
    }

    /**
     * // --- Talep oluşturma
     * @return void
     */
    public function store(): void
    {
        $this->validateCsrfOrAbort();
        $userId = (int) $this->session->get('user_id', 0);
        if ($userId === 0) {
            $this->response->redirect('/login');
            return;
        }

        $ticketId = $this->tickets->create([
            'user_id' => $userId,
            'subject' => (string) $this->request->input('subject'),
            'message' => (string) $this->request->input('message'),
        ]);

        $this->response->redirect('/tickets');
    }
}
