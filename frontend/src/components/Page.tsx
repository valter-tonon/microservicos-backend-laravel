// @flow
import * as React from 'react';
import {Container, makeStyles, Typography} from "@material-ui/core";

const useStyles = makeStyles({
    title: {
        color:'#999999'
    }
})


type Props = {
    title: string
};
export const Page:React.FC<Props> = (props) => {
    const classes = useStyles()
    return (
        <Container>
            <Typography className={classes.title} component="h1" variant="h5" style={{marginTop: '30px'}}>
                {props.title}
            </Typography>
            {props.children}
        </Container>
    );
};