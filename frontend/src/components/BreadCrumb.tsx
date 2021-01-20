/* eslint-disable no-nested-ternary */
// @ts-ignore
import React from 'react';
import { makeStyles, Theme, createStyles } from '@material-ui/core/styles';
import Link, { LinkProps } from '@material-ui/core/Link';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import Typography from '@material-ui/core/Typography';
import ExpandLess from '@material-ui/icons/ExpandLess';
import ExpandMore from '@material-ui/icons/ExpandMore';
import UIBreadcrumbs from '@material-ui/core/Breadcrumbs';
import { Route } from 'react-router';
import {Location} from 'history'
import { Link as RouterLink } from 'react-router-dom';
import { Omit } from '@material-ui/types';
import RouteParser from 'route-parser';
import {Container} from "@material-ui/core";
import ArrowRightIcon from '@material-ui/icons/ArrowRight';

interface ListItemLinkProps extends LinkProps {
    to: string;
    open?: boolean;
}

const breadcrumbNameMap: { [key: string]: string } = {
    '/': 'Início',
    '/categories' : 'Categorias',
    '/categories/:id/edit' : 'Editar',
    '/cast-members' : 'Membros de elenco',
    '/generos' : 'Gêneros',
    '/categories/create' : 'Criar Categorias',
    '/cast-members/create' : 'Criar Membros de Elenco',
    '/generos/create' : 'Criar Gêneros'
};

function ListItemLink(props: Omit<ListItemLinkProps, 'ref'>) {
    const { to, open, ...other } = props;
    const primary = breadcrumbNameMap[to];

    return (
        <li>
            <ListItem button component={RouterLink} to={to} {...other}>
    <ListItemText primary={primary} />
    {open != null ? open ? <ExpandLess /> : <ExpandMore /> : null}
    </ListItem>
    </li>
);
}

const useStyles = makeStyles((theme: Theme) =>
    createStyles({
        item: {
            color: '#4db5db',
            "&:hover":{
                color: '#055a52',
                textDecoration: 'none'
            }
        }

    }),
);

interface LinkRouterProps extends LinkProps {
    to: string;
    replace?: boolean;
}

const LinkRouter = (props: LinkRouterProps) => <Link {...props} component={RouterLink as any} />;

export default function Breadcrumbs() {
    const classes = useStyles();

    function makeBreadcrumb(location: Location){
        const pathnames = location.pathname.split('/').filter((x) => x);
        pathnames.unshift('/')
        return (
            <UIBreadcrumbs aria-label="breadcrumb">
                {pathnames.map((value, index) => {
                    const last = index === pathnames.length - 1;
                    const to = `${pathnames.slice(0, index + 1).join('/').replace('//','/')}`;
                    const route = Object.keys(breadcrumbNameMap).find(path=>new RouteParser(path).match(to))

                    if (route === undefined) {
                        return false
                    }

                    return last ? (
                        <Typography color="textPrimary" key={to}>
                            {breadcrumbNameMap[route]}
                        </Typography>
                    ) : (
                        <LinkRouter color="inherit" to={to} key={to} className={classes.item}>
                            {           breadcrumbNameMap[route]}
                        </LinkRouter>
                    );
                })}
            </UIBreadcrumbs>
        );
    }

    return (
        <Container>
            <Route>
                {
                    ({location}:{location: Location}) => makeBreadcrumb(location)
                }
            </Route>
        </Container>
    );
}
