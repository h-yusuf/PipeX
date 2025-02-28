(function ($) {
    $.fn.MultiStep = function (options) {
        // Default settings
        var settings = $.extend({
            stepContainerClass: '.step-container',
            stepClass: '.step',
            stepSummaryClass: '.step-summary',
            nextButtonClass: '.next-step',
            prevButtonClass: '.prev-step',
            finishButtonClass: '.finish-step',
            activeClass: 'active',
            isForm: false,
            formId: '#form',
            excludeInputType: 'radio',
            addSummaryForm: false,
            validatorMessageId: '#validator-messsage',
            /**
             * id input as key
             * error message as value
             *   example:
             *      { 'name': 'must exist!' }
             */
            validatorMessages: {},
            multiSelectInput: {},
            /**
             * callback for clicked finish button
             * with value passing is formValues
             */
            onFinish: function () {
                alert('Multi-step process completed!');
            }
        }, options);

        // Plugin logic
        return this.each(function () {
            var $element = $(this);
            const useSummaryForm = settings.isForm && settings.addSummaryForm;
            var $steps = $element.find(settings.stepClass);

            if (useSummaryForm) {
                $steps = $element.find(`${settings.stepClass},${settings.stepSummaryClass}`);
            }

            var currentStep = 0;

            const MAXIMUM_STEP = ($steps.length - 1);
            const INVALID_MAXIMUM_STEP = -1;

            // Initialize steps
            $steps.hide().eq(currentStep).addClass(settings.activeClass).show();

            function updateButtonStep() {
                $element.find(settings.prevButtonClass).prop('disabled', !currentStep);
                $element.find(settings.nextButtonClass).prop('disabled', currentStep == MAXIMUM_STEP);

                // can submit when maximum step is invalid
                $element.find(settings.finishButtonClass)
                    .prop('disabled', currentStep != MAXIMUM_STEP && MAXIMUM_STEP !== INVALID_MAXIMUM_STEP
                    );
            }

            function disableAllButtonSteps() {
                $element.find(settings.prevButtonClass).prop('disabled', true);
                $element.find(settings.nextButtonClass).prop('disabled', true);
                $element.find(settings.finishButtonClass).prop('disabled', true);
            }

            function updateClassInput($input, resetOnly = false) {
                const isInputValid = $input.checkValidity();

                if (resetOnly) {
                    $($input).removeClass('is-valid').removeClass('is-invalid');
                    return;
                }

                if (!isInputValid) {
                    $($input).removeClass('is-valid').addClass('is-invalid');
                } else {
                    $($input).removeClass('is-invalid').addClass('is-valid');
                }
            }

            // validity of all active step active
            function checkInputValidities(checkAll = false, resetOnly = false) {
                let isValid = true;

                if (!settings.isForm) return isValid;

                const formEl = $(settings.formId);
                let formInputEl = formEl;

                // only for active class input
                if (!checkAll) {
                    formInputEl = formInputEl.find(`.${settings.activeClass}`);
                }

                formInputEl = formInputEl.find(`input:not([type="${settings.excludeInputType}"]`);

                for (const formInput of formInputEl) {
                    updateClassInput(formInput, resetOnly);

                    isValid &= formInput.checkValidity();
                }

                return isValid;
            }

            function getSummaryForm() {
                const formValues = {};
                let orders = new Set();

                $(settings.formId).find('input, select, textarea').each(function () {
                    const name = $(this).attr('name');
                    let value = '';

                    const inputId = $(this).attr('id');
                    let label = $(`label[for="${inputId}"]`)?.text() || '';

                    let prefix = '';
                    let suffix = '';
                    const parentEl = $(this).parent();

                    if ($(this).is(':radio') || $(this).is(':checkbox')) {
                        value = $(this).is(':checked') ? $(this).val() : '';
                        label = $(`label[for="${name}"]`)?.text() || '';
                    } else {
                        value = $(this).val();
                    }

                    // get prefix and suffix for input group
                    if (parentEl.hasClass('input-group')) {
                        const inputGroupText = parentEl.find('.input-group-text');

                        prefix = $(inputGroupText[0])?.text() || '';
                        suffix = $(inputGroupText[1])?.text() || '';
                    }

                    if (name) {
                        orders.add(name);

                        const comboValues = {
                            value,
                            label,
                            prefix,
                            suffix,
                        }

                        // multiple value
                        if (name.includes('[]')) {
                            if (formValues[name] === undefined) {
                                formValues[name] = [comboValues];
                            } else {
                                formValues[name] = [...formValues[name], comboValues];
                            }
                        }

                        // checkbox
                        else if (formValues[name] && $(this).is(':checkbox')) {
                            formValues[name].value = formValues[name].value ?
                                formValues[name].value + ',' + value : value;
                        }
                        // radio checked
                        else if ($(this).is(':radio') && $(this).is(':checked')) {
                            formValues[name] = comboValues;
                        }
                        // freetext input
                        else if (!$(this).is(':radio')) {
                            formValues[name] = comboValues;
                        }
                    }
                });

                return [orders, formValues];
            }

            function generateStepSummaryContent() {
                const [orders, formValues] = getSummaryForm();

                const mainEl = $('#step-summary-content');

                if (mainEl.length) mainEl.remove();

                const container = `
                <div>
                    <dl id="step-summary-content" class="row mb-0">
                        <dt class="col-sm-12 mb-3">
                            <h5>
                                Summary Form
                            </h5>
                        </dt>
                        :content
                    <dl>
                </div>
                `;

                let content = '';

                for (let [_, valueOrder] of orders.entries()) {
                    if (valueOrder === undefined) continue;

                    const {
                        value,
                        label,
                        prefix,
                        suffix,
                    } = formValues[valueOrder]

                    content += `
                        <dt class="col-sm-12">
                            <h5>
                                ${label}
                            </h5>
                        </dt>
                        <dd class="col-sm-12 mb-3">
                            <p class="m-0">
                                ${prefix}${value}${suffix}
                            </p>
                        </dd>
                    `;
                }

                const containerNcontent = container.replace(
                    ':content', content
                );

                $(settings.stepSummaryClass).prepend(containerNcontent);
            }

            function changeStep(newStep) {
                $steps.eq(currentStep).removeClass(settings.activeClass).hide();

                if (newStep === MAXIMUM_STEP) {
                    $steps.eq(MAXIMUM_STEP).addClass(settings.activeClass).show();
                    generateStepSummaryContent();
                }

                else {
                    $steps.eq(newStep).addClass(settings.activeClass).show();
                }

                currentStep = newStep;
            }

            function resetStep() {
                changeStep(0);
                $(settings.formId)[0].reset();
                checkInputValidities(true, true);
            }

            // setup input validation checker
            function setupInputValidation() {
                if (!settings.isForm) return

                const $form = $(settings.formId);
                const $formInput = $form.find(`input:not([type="${settings.excludeInputType}"]`);

                for (const $input of $formInput) {
                    const type = $($input).attr('type');
                    const inputId = $($input).attr('id');

                    $($input).on('input', function (e) {
                        const value = e?.target?.value;
                        const currValidity = $input.checkValidity();

                        // force remove non integer "telephone" input
                        if (type === 'tel' && /\D/.test(value)) {
                            e.target.value = value.replace(/\D/, '');
                            return;
                        }

                        let targetMessagePlace = $(this);
                        if (targetMessagePlace.parent().hasClass('input-group')) {
                            targetMessagePlace = targetMessagePlace.parent();
                        }

                        // check next element input is validator or not
                        const isExistValidatorMessageEl = targetMessagePlace.next()
                            .attr('id') === settings.validatorMessageId;

                        if (isExistValidatorMessageEl) {
                            targetMessagePlace.next().remove();
                        }

                        if (!currValidity) {
                            targetMessagePlace.after(`
                                <div id="${settings.validatorMessageId}">
                                    <p class="text-danger m-0">
                                        ${settings.validatorMessages[inputId]}
                                    </p>
                                </div>
                            `)
                        }

                        updateClassInput($input);
                    })
                }
            }

            // use for add select with input for other option
            function setupMultiSelectInput() {
                const multiSelectInputId = Object.keys(settings.multiSelectInput);

                if (!multiSelectInputId.length) return;

                for (const selectInputId of multiSelectInputId) {
                    const { inputId } = settings.multiSelectInput[selectInputId];

                    const $selectInput = $element.find(selectInputId);
                    const $input = $element.find(inputId);

                    // shows input freetext when value target is match
                    $($selectInput).on('change', function (event) {
                        const { value } = event.currentTarget;
                        const { valueShows } = settings.multiSelectInput[selectInputId];

                        $input.attr('hidden', !valueShows.includes(value));
                        $input.attr('required', valueShows.includes(value));
                    });

                    $input.attr('hidden', true);
                    $input.attr('required', false);
                }
            }

            // Next button click event
            $element.find(settings.nextButtonClass).click(function () {
                const isValidForm = checkInputValidities();

                if (!isValidForm) return;

                if (currentStep < MAXIMUM_STEP) {
                    const newStep = currentStep + 1;
                    changeStep(newStep);
                }

                updateButtonStep();
            });

            // Previous button click event
            $element.find(settings.prevButtonClass).click(function () {
                if (currentStep > 0) {
                    const newStep = currentStep - 1;
                    changeStep(newStep);
                }

                updateButtonStep();
            });

            setupInputValidation();
            updateButtonStep();
            setupMultiSelectInput();

            // Finish button click event
            $element.find('.finish-step').click(async function () {
                const isValidForm = checkInputValidities(true);

                if (!isValidForm) return;

                const [_, formValues] = getSummaryForm();

                let values = {};

                // patch data to values
                // id: value
                for (let key of Object.keys(formValues)) {
                    if (key === undefined) continue;

                    const isArrayValues = Array.isArray(formValues[key]);

                    if (isArrayValues) {
                        values[key] = formValues[key]?.map((item) => item.value);
                        continue;
                    }

                    values[key] = formValues[key]?.value;
                }

                disableAllButtonSteps();
                const result = await settings.onFinish(values);

                if (result) resetStep();

                updateButtonStep();
                setupMultiSelectInput();
            });
        });
    };
}(jQuery));
