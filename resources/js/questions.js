export default function quizSelector(tenant_id = "", quiz_id = "") {
    return {
        selectedTenant: tenant_id,
        selectedQuiz: quiz_id,
        filteredQuizzes: [],

        init() {
            if (tenant_id) {
                this.fetchQuizzes(tenant_id);
            }
            this.$watch("selectedTenant", (value) => {
                if (value) {
                    this.fetchQuizzes(value);
                } else {
                    this.filteredQuizzes = [];
                }
            });
            this.$watch("filteredQuizzes", (value) => {
                if (value) {
                    // Loop in value and set the values in the select with id quiz_id
                    const select = document.getElementById("quiz_id");
                    select.innerHTML = "";
                    const option = document.createElement("option");
                    option.value = "";
                    option.innerText = "Select an option";

                    option.setAttribute("disabled", true);
                    option.setAttribute("hidden", true);
                    option.setAttribute("selected", quiz_id ? false: true);

                    select.appendChild(option);
                    value.forEach((quiz) => {
                        const option = document.createElement("option");
                        option.value = quiz.id;
                        option.innerText = quiz.title;
                        if (quiz.id == quiz_id) {
                            option.setAttribute("selected", true);
                        }
                        select.appendChild(option);
                    });
                }
            });
        },

        fetchQuizzes(tenantId) {
            axios.get(`/api/quizzes/${tenantId}`).then((response) => {
                this.filteredQuizzes = response.data;
            });
        },
    };
}
