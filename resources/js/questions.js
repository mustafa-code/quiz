

export default function quizSelector() {
    return {
        selectedTenant: '',
        selectedQuiz: '',
        filteredQuizzes: [],

        init() {
            this.$watch('selectedTenant', value => {
                if (value) {
                    this.fetchQuizzes(value);
                } else {
                    this.filteredQuizzes = [];
                }
            });
            this.$watch('filteredQuizzes', value => {
                if (value) {
                    // Loop in value and set the values in the select with id quiz_id
                    const select = document.getElementById('quiz_id');
                    select.innerHTML = '';
                    const option = document.createElement('option');
                    option.value = '';
                    option.innerText = 'Select an option';

                    option.setAttribute('disabled', true);
                    option.setAttribute('hidden', true);
                    option.setAttribute('selected', true);

                    select.appendChild(option);
                    value.forEach(quiz => {
                        const option = document.createElement('option');
                        option.value = quiz.id;
                        option.innerText = quiz.title;
                        select.appendChild(option);
                    });
                }
            });
        },

        fetchQuizzes(tenantId) {
            axios.get(`/api/quizzes/${tenantId}`)
                .then(response => {
                    this.filteredQuizzes = response.data;
                });
        }
    };
}
