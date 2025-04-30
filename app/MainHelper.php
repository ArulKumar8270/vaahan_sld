<?php

namespace App\Helpers;

use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\RegistrationsRepository;
use App\Repositories\RoleRepository;
use App\Repositories\DistributorRepository;
use App\Repositories\SubDistributorRepository;

class MainHelper {

	protected $repository;

	protected $categoryRepository;
	protected $userRepository;
	protected $documentRepository;
	protected $registrationsRepository;
	protected $roleRepository;
	protected $distributorRepository;
	protected $subDistributorRepository;

	public function __construct(CategoryRepository $categoryRepo,UserRepository $userRepo,DocumentRepository $documentRepo,RegistrationsRepository $registrationsRepo, RoleRepository $roleRepo, DistributorRepository $distributorRepo, SubDistributorRepository $subDistributorRepo
								
                                ) {
		
		$this->categoryRepository = $categoryRepo;
		$this->userRepository = $userRepo;
		$this->documentRepository = $documentRepo;
		$this->registrationsRepository = $registrationsRepo;
		$this->roleRepository = $roleRepo;
		$this->distributorRepository = $distributorRepo;
		$this->subDistributorRepository = $subDistributorRepo;
                                }
}