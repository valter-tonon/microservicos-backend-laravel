// @flow
// @ts-ignore
import * as React from 'react';
import {Box, Button, ButtonProps, Checkbox, makeStyles, TextField, Theme} from "@material-ui/core";
import {useForm} from "react-hook-form";
import {httpVideo} from "../../util/http";
import categoryHttp from "../../util/http/category-http";

const useStyles = makeStyles((theme: Theme) =>{
       return {
           submit: {
               margin: theme.spacing(1)

           }
       }
})
// @ts-ignore
export function Form() {
    const classes = useStyles()
    const buttonProps: ButtonProps ={
        variant: "outlined",
        size: "medium",
        color: "primary",
        className: classes.submit
    }

    const {register, handleSubmit, getValues} = useForm({
        defaultValues:{
            is_active: true
        }
    })

    function onSubmit(formData: any) {
        categoryHttp
            .create(formData)
            .then((response) => console.log(response))
    }

    return (
        <form onSubmit={handleSubmit(onSubmit)}>
            <TextField
                name="name"
                label="Nome"
                fullWidth
                variant="outlined"
                margin="normal"
                inputRef={register}/>
            <TextField
                name="description"
                label="Descrição"
                multiline
                rows='4'
                fullWidth
                variant="outlined"
                inputRef={register}
                margin="normal"/>
            <Checkbox
                name="is_active"
                inputRef={register}
                defaultChecked
            />
            Ativo?

            <Box dir="rtl">
                <Button  {...buttonProps} onClick={() => onSubmit(getValues())}>Salvar</Button>
                <Button  {...buttonProps} type="submit">Salvar e continuar</Button>

            </Box>
        </form>
    );
};