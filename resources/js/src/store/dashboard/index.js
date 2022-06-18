import axios from 'axios'

export default {
    namespaced: true,
    state: {
        allOrganizations:[]
    },
    getters: {
        getAllOrganizations(state){
            return state.allOrganizations
        }
    },
    mutations: {
        SET_ALL_ORGANIZATIONS(state, val) {
            state.allOrganizations = val
        },
    },
    actions: {
        getAllOrganizationsAction(context) {
            axios.get('all-organizations', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
                },
            }).then(response => {
                context.commit('SET_ALL_ORGANIZATIONS',response.data.data)
            })
        }
    }
}
