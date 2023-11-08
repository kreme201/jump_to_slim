<?php

declare(strict_types=1);

namespace App\Application\Member\Actions;

use App\Application\Member\MemberService;
use App\Core\Abstracts\Action;
use App\Core\Interfaces\PasswordEncryptInterface;
use Psr\Http\Message\ResponseInterface;

class MemberLoginAction extends Action
{
    public function __construct(
        private readonly MemberService $memberService,
        private readonly PasswordEncryptInterface $passwordEncrypt,
    ) {
    }

    protected function action(): ResponseInterface
    {
        $data = [];
        if ($this->isPost()) {
            $data = $this->request->getParsedBody();

            if (!empty($data['username'])) {
                $member = $this->memberService->find_by_email($data['username']);

                if (!empty($member) && $this->passwordEncrypt->verify($data['password'], $member['password'])) {
                    $_SESSION['user_id'] = $member['id'];

                    return $this->redirectByName('board_list');
                } else {
                    $data['error'] = 'Not found member';
                }
            }
        }

        return $this->view('member/login.twig', $data);
    }
}
