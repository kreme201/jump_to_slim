<?php
declare(strict_types=1);

namespace App\Actions\Member;

use App\Actions\Action;
use App\Domain\Member\MemberRepository;
use Psr\Http\Message\ResponseInterface;

class MemberRegisterAction extends Action
{
    public function __construct(
        private MemberRepository $memberRepository,
    ) {}

    protected function action(): ResponseInterface
    {
        if ($this->request->getMethod() === 'GET') {
            return $this->json($this->memberRepository->search());
        } elseif ($this->request->getMethod() === 'POST') {
            $member = $this->memberRepository->create($this->request->getParsedBody());
            return $this->json($member->jsonSerialize());
        }
    }
}