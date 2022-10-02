@extends('layouts.app')

@section('content')
    <div class="admin-page" id="app">
        <header class="page-header">
            <h1 class="page-header-title">Идём<span>в</span>кино</h1>
            <span class="page-header-subtitle">Администраторррская</span>
        </header>

        <main>
            <div class="conf-steps">
                <section class="conf-step">
                    <header class="conf-step-header conf-step-header_opened">
                        <h2 class="conf-step-title">Управление залами</h2>
                    </header>
                    <halls-management-component></halls-management-component>
                </section>

                <section class="conf-step">
                    <header class="conf-step-header conf-step-header_opened">
                        <h2 class="conf-step-title">Конфигурация залов</h2>
                    </header>
                    <config-hall-component></config-hall-component>
                </section>

                <section class="conf-step">
                    <header class="conf-step-header conf-step-header_opened">
                        <h2 class="conf-step-title">Конфигурация цен</h2>
                    </header>
                    <config-price-component></config-price-component>
                </section>

                <section class="conf-step">
                    <header class="conf-step-header conf-step-header_opened">
                        <h2 class="conf-step-title">Сетка сеансов</h2>
                    </header>
                    <setting-up-sessions></setting-up-sessions>
                </section>

                <section class="conf-step">
                    <header class="conf-step-header conf-step-header_opened">
                        <h2 class="conf-step-title">Открыть (приостановить) продажи</h2>
                    </header>
                    <sales-component></sales-component>
                </section>
            </div>
        </main>
    </div>
@endsection
