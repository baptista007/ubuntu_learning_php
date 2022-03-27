//Angular Functions
var app = angular.module('007App', ['ng-reset-on', 'ui.bootstrap']);

app.run(function ($rootScope) {
    $rootScope.mysqlDateToJSDate = function (dateString) {
        return new Date(Date.parse(dateString.replace('-', '/', 'g')));
    };
});

app.filter('toJSDate', function () {
    return function (dateString) {
        return new Date(Date.parse(dateString.replace('-', '/', 'g')));
    };
});

app.directive('format', ['$filter', function ($filter) {
        return {
            require: '?ngModel',
            link: function (scope, elem, attrs, ctrl) {
                if (!ctrl)
                    return;

                ctrl.$formatters.unshift(function (a) {
                    return $filter(attrs.format)(ctrl.$modelValue)
                });

                elem.bind('blur', function (event) {
                    var plainNumber = elem.val().replace(/[^\d|\-+|\.+]/g, '');
                    elem.val($filter(attrs.format)(plainNumber));
                });
            }
        };
    }]);

app.directive('input', [function () {
        return {
            restrict: 'E',
            require: '?ngModel',
            link: function (scope, element, attrs, ngModel) {
                if (
                        'undefined' !== typeof attrs.type
                        && 'number' === attrs.type
                        && ngModel
                        ) {
                    ngModel.$formatters.push(function (modelValue) {
                        return Number(modelValue);
                    });

                    ngModel.$parsers.push(function (viewValue) {
                        return Number(viewValue);
                    });
                }
            }
        }
    }]);

app.directive('select', [function () {
        return {
            restrict: 'E',
            require: '?ngModel',
            link: function (scope, element, attrs, ngModel) {
                if (ngModel) {
                    ngModel.$isEmpty = function (value) {
                        return !value || value.length === 0;
                    }
                }
            }
        }
    }]);

app.controller('quizCtrl', ['$scope', '$window', function ($scope, $window) {
        $scope.questions = [];

        angular.element(document).ready(function () {
            if (!isEmpty($window.questions)) {
                $window.questions.forEach(function (currentValue, index, arr) {
                    $scope.questions.push({
                        question: currentValue.question,
                        options: currentValue.options,
                        correct_option: currentValue.correct_value
                    });
                });
            } else {
                $scope.add();
            }

            $scope.$apply();
        });

        $scope.add = function () {
            $scope.questions.push({
                question: '',
                options: [],
                correct_option: ''
            });
        };

        $scope.removeQuestion = function (index) {
            $scope.questions.splice(index, 1);
        };

        $scope.addOption = function (index) {
            $scope.questions[index].options.push({
                value: '',
                erro_note: ''
            });
        };

        $scope.removeOption = function (index, innerIndex) {
            $scope.questions[index].options.splice(innerIndex, 1);
        };

        $scope.saveQuiz = function (url, reload_url) {
            $('#feedback').html('');

            if ($scope.questions.length < 1) {
                scrollToElement('feedback');
                $('#feedback').html('<div class="alert alert-danger animated shake">Please provide at least one question before saving.</div>');
                return false;
            }

            var data = {
                title: $scope.title,
                grade: $('#grade').val(),
                duration: $scope.duration,
                questions: $scope.questions
            },
                    $btn = $("#btn-submit");

            $btn.button('loading');
            try {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function (data) {
                        $('#feedback').html('<div class="alert alert-' + (data.success ? 'success' : 'danger') + ' animated shake">' + data.message + '</div>');
                        scrollToElement('feedback');

                        if (data.success) {
                            setTimeout(function () {
                                window.location.href = data.redirectUrl;
                            }, 1500);
                        } else {
                            $btn.button('reset');
                        }
                    },
                    dataType: 'json'
                })
                .fail(function (xhr, status, error) {
                    $('#feedback').html('<div class="alert alert-danger animated shake">' + error + '</div>');
                    scrollToElement('feedback');
                    $btn.button('reset');
                });

            } catch (err) {
                $('#feedback').html('<div class="alert alert-danger animated shake">' + err + '</div>');
                scrollToElement('feedback');
                $btn.button('reset');
            }
        }
    }]);


app.controller('quizTrialCtrl', ['$scope', '$window', function ($scope, $window) {
        $scope.questions = [];
        $scope.activeQuestion = 0;
        $scope.error = false;
        $scope.finalise = false;

        angular.element(document).ready(function () {
            if (!isEmpty($window.questions)) {
                $window.questions.forEach(function (currentValue, index, arr) {
                    $scope.questions.push({
                        question: currentValue.question,
                        options: currentValue.options,
                        correct_option: currentValue.answer,
                        selected: null
                    });
                });
            }

            $scope.$apply();
        });

        $scope.setActiveQuestion = function (index) {
            // no argument passed, data = undefined.
            if (index === undefined) {
                var breakOut = false;

                /*
                 * quizLength is set to 1 less than the length of the quiz as it
                 * is always referenced against the variable activeQuestion
                 * which is 0 index. Therefore the length needs to be one less.
                 */
                var quizLength = $scope.questions.length - 1;

                /*
                 * This while loop will loop continuously until an unanswered
                 * question is found. Going back to the first question if the
                 * last question is reached witout finding an unanswered question
                 */
                while (!breakOut) {
                    // check if last question is reach, if not increment. If it
                    // has go back to start.
                    $scope.activeQuestion = $scope.activeQuestion < quizLength ? ++$scope.activeQuestion : 0;

                    /*
                     * activeQuestion has looped back to start. Meaning user has
                     * skipped past questions without answering them. Therefore
                     * show a warning. This is done by setting the error flag to
                     * true.
                     */
                    if ($scope.activeQuestion === 0) {
                        $scope.error = true;
                    }

                    // if current active question has not been selected, break
                    // out the while loop
                    if ($scope.questions[$scope.activeQuestion].selected === null) {
                        breakOut = true;
                    }
                }
            } else {
                // Data was passed into the function therefore
                // Set activeQuestion to the index of the button pressed
                vm.activeQuestion = index;
            }
        }

        $scope.selectAnswer = function (index) {
            $scope.questions[$scope.activeQuestion].selected = index;
        }
    }]);