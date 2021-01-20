import * as React from "react";
import {IconButton, Menu as UiMenu, MenuItem} from '@material-ui/core'
import MenuIcon from "@material-ui/icons/Menu";
import {useState} from "react";
import {Link} from "react-router-dom";
import routes, {MyRouteProps} from "../../routes";

const listRoutes = [
    'dashboard',
    'categories.list',
    'generos.list',
    'cast_members.list'
]

const menuRoutes = routes.filter(route => listRoutes.includes(route.name))
export const Menu = () =>{

    const [anchorEl, setAnchorEl] = useState(null)
    const open = Boolean(anchorEl)
    const openSubmit = (event:any) => setAnchorEl(event.currentTarget)
    const handleClose = () => setAnchorEl(null)
    return(
        <>
            <IconButton
                color="inherit"
                edge="start"
                aria-controls='menu-appbar'
                aria-haspopup='true'
                onClick={openSubmit}
            >
                <MenuIcon/>
            </IconButton>
            <UiMenu
                id='menu-appbar'
                open={open}
                anchorEl={anchorEl}
                onClose={handleClose}
                anchorOrigin={{vertical: 'bottom', horizontal: 'center'}}
                transformOrigin={{vertical: 'top', horizontal: 'center'}}
                getContentAnchorEl={null}
            >
                {
                    menuRoutes.map((route, key) =>(
                        <MenuItem onClick={handleClose} component={Link} to={route.path} key={key}>{route.label}</MenuItem>
                    ))
                }
            </UiMenu>
        </>
    )
}
