<?php

declare(strict_types=1);

namespace App\Application\Member\Actions;

use App\Application\Member\MemberService;
use App\Core\Abstracts\Action;
use Psr\Http\Message\ResponseInterface;

class MemberFormAction extends Action
{
    public function __construct(
        private readonly MemberService $memberService,
    ) {
    }

    protected function action(): ResponseInterface
    {
        $data = [];

        if ($this->isPost()) {
            $data = (array) $this->request->getParsedBody();

            if (empty($data['email'])) {
                $data['error'] = 'Email Required';
            } elseif (empty($data['name'])) {
                $data['error'] = 'Name Required';
            } elseif (empty($data['password'])) {
                $data['error'] = 'Password Required';
            } else {
                $result = $this->memberService->add($data['email'], $data['name'], $data['password']);

                if ($result) {
                    return $this->redirectByName('board_list');
                } else {
                    $data['error'] = 'Unknown Error';
                }
            }
        }

        return $this->view('member/form.twig', $data);
    }
}
