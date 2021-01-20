// @flow
// @ts-ignore
import * as React from 'react';
import {
    Box,
    Button,
    ButtonProps,
    Checkbox,
    FormControl, FormControlLabel,
    FormLabel,
    makeStyles, Radio, RadioGroup,
    TextField,
    Theme
} from "@material-ui/core";
import {useForm} from "react-hook-form";
import {httpVideo} from "../../util/http";
import categoryHttp from "../../util/http/category-http";
import castMembersHttp from "../../util/http/cast-members-http";
import {useEffect} from "react";

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

    const {register, handleSubmit, getValues, setValue} = useForm()

    useEffect(() =>{
        register({name: 'type'})
    },[register])

    function onSubmit(formData: any) {
        castMembersHttp
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

            <FormControl margin={'normal'}>
                <FormLabel component={'legend'}>Tipo</FormLabel>
                <RadioGroup
                    name="type"
                    onChange={(e) =>{
                        setValue('type', parseInt(e.target.value))
                    }}
                >
                    <FormControlLabel value='0' control={<Radio/>} label={'Diretor'}/>

                    <FormControlLabel value='1' control={<Radio/>} label={'Ator'}/>
                </RadioGroup>

            </FormControl>
            <Box dir="rtl">
                <Button  {...buttonProps} onClick={() => console.log(getValues())}>Salvar</Button>
                <Button  {...buttonProps} type="submit">Salvar e continuar</Button>

            </Box>
        </form>
    );
};