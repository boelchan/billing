<?php

namespace App\Providers;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // vertical
        Form::component('vEmail', 'components.form.email', ['label', 'name', 'value' => null, 'attributes' => []]);
        Form::component('vText', 'components.form.text', ['label', 'name', 'value' => null, 'attributes' => []]);
        Form::component('vNumber', 'components.form.number', ['label', 'name', 'value' => null, 'attributes' => []]);
        Form::component('vDate', 'components.form.date', ['label', 'name', 'value' => null, 'attributes' => []]);
        Form::component('vTextarea', 'components.form.textarea', ['label', 'name', 'value' => null, 'attributes' => []]);
        Form::component('vSelect', 'components.form.select', ['label', 'name', 'data' => [], 'value' => null, 'attributes' => []]);
        Form::component('vSelect2', 'components.form.select2', ['label', 'name', 'data' => [], 'value' => null, 'attributes' => []]);
        // horizontal
        Form::component('hText', 'components.form.text', ['label', 'name', 'value' => null, 'attributes' => []]);
        Form::component('hNumber', 'components.form.number', ['label', 'name', 'value' => null, 'attributes' => []]);
        Form::component('hDate', 'components.form.date', ['label', 'name', 'value' => null, 'attributes' => []]);
        Form::component('hTextarea', 'components.form.textarea', ['label', 'name', 'value' => null, 'attributes' => []]);
        Form::component('hSelect', 'components.form.select', ['label', 'name', 'data' => [], 'value' => null, 'attributes' => []]);
        Form::component('hSelect2', 'components.form.select2', ['label', 'name', 'data' => [], 'value' => null, 'attributes' => []]);
    }
}
