@extends('layouts.layout')
@section('title', 'Connexion')

@section('content')
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card shadow-lg border-0 rounded-4">

                    <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                        <div class="mb-3">
                            <i class="bi bi-person-lock display-4"></i>
                        </div>
                        <h1 class="h3 mb-1 fw-bold">Connexion</h1>
                        <p class="mb-0 opacity-75">Accédez à votre espace</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('login.submit') }}" method="POST">
                            @csrf

                            <x-input type="email" 
                                     label="Adresse e-mail" 
                                     name="email" 
                                     placeholder="votre@email.com" />

                            <x-input type="password" 
                                     label="Mot de passe" 
                                     name="password" 
                                     placeholder="••••••••" />

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection