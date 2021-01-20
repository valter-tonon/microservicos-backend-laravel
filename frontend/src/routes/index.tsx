import {RouteProps} from 'react-router-dom'
import Dashboard from "../pages/Dashboard";
import Categories from "../pages/Category/Categories";
import {Generos} from "../pages/Generos";
import {CastMembers} from "../pages/CastMembers";
import {PageForm} from "../pages/Category/PageForm";
import {PageFormCastMembers} from "../pages/CastMembers/PageForm";
import {PageFormGenres} from "../pages/Generos/PageForm";

export interface MyRouteProps extends RouteProps{
    name: string
    label: string
}

const routes : MyRouteProps[]= [
    {
        name: 'dashboard',
        label: 'Dashboard',
        path: '/',
        component: Dashboard,
        exact: true
    },
    {
        name: 'categories.list',
        label: 'Listar categorias',
        path: '/categories',
        component: Categories,
        exact: true
    },
    {
        name: 'generos.list',
        label: 'Gêneros',
        path: '/generos',
        component: Generos,
        exact: true
    },
    {
        name: 'cast_members.list',
        label: 'Membros de Elenco',
        path: '/cast-members',
        component: CastMembers,
        exact: true
    },
    {
        name: 'cast_members.create',
        label: 'Cadastrar Membros de Elenco',
        path: '/cast-members/create',
        component: PageFormCastMembers,
        exact: true
    },
    {
        name: 'categories.create',
        label: 'Criar Categorias',
        path: '/categories/create',
        component: PageForm,
        exact: true

    },
    {
        name: 'generos.create',
        label: 'Criar Gêneros',
        path: '/generos/create',
        component: PageFormGenres,
        exact: true
    }
]

export default routes

