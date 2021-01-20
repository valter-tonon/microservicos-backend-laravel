import * as React from 'react'
import {AppBar, Button, Toolbar, makeStyles, Typography, Theme} from "@material-ui/core";
import {Menu} from './Menu'
import logo from '../../assets/images/logo.png'

const useStyles = makeStyles((theme: Theme)=>({
    toolbar: {
        backgroundColor: '#000000'
    },
    title: {
        flexGrow: 1,
        textAlign: 'center'
    },
    logo: {
        width: 100,
        [theme.breakpoints.up('sm')]: {
            width: 170
        }
    }
}))

export const Navbar : React.FC = () => {
    const classes = useStyles()
    return (
        <AppBar>
            <Toolbar className={classes.toolbar}>
                <Menu/>
                <Typography className={classes.title}>
                    <img src={logo} alt="logo" className={classes.logo}/>
                </Typography>
                <Button color="inherit">login</Button>
            </Toolbar>
        </AppBar>
    )
} 