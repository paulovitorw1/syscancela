@extends('Layout.login')
@section('formulario-login')
    <div class="ui container">
        <div class="ui grid">
            <div class="ui grid row centered">
                <div class="ui grid column six wide ">
                    <form>
                        <div class="ui form row linhaForm" id="linhaForm">
                            <input type="text" name="email" placeholder="E-mail">
                         </div>
                        <div class="ui form row linhaForm" id="linhaForm">
                            <input type="password" name="password" placeholder="Senha">
                        </div>
                        <div class="ui form row">
                            <button type="submit" class="ui fluid button" style="background-color: transparent; color:white;  border: 1px solid white; ">
                                <font style="vertical-align: inherit;">Login</font>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection