// @flow
// @ts-ignore
import * as React from 'react';
import {Box, Button, ButtonProps, Checkbox, makeStyles, MenuItem, TextField, Theme} from "@material-ui/core";
import {useForm} from "react-hook-form";
import {httpVideo} from "../../util/http";
import categoryHttp from "../../util/http/category-http";
import {useEffect, useState} from "react";
import genresHttp from "../../util/http/genre-http";

const useStyles = makeStyles((theme: Theme) =>{
       return {
           submit: {
               margin: theme.spacing(1)

           }
       }
})
// @ts-ignore
export function Form() {

    const [categories, setCategories] = useState<any[]>([])
    const classes = useStyles()
    const buttonProps: ButtonProps ={
        variant: "outlined",
        size: "medium",
        color: "primary",
        className: classes.submit
    }

    const {register, handleSubmit, getValues, setValue, watch} = useForm({
        defaultValues: {categories_id:[]}
    } )
    const category = getValues()['categories_id']

    useEffect(() =>{
        register({name: "categories_id"})
    },[register])

    useEffect(()=>{
        categoryHttp
            .list()
            .then(response => setCategories(response.data))
    },[])
    function onSubmit(formData: any) {
        genresHttp
            .create(formData)
            .then((response) => console.log(response))
    }

    // @ts-ignore
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
                name="categories_id"
                label="Categorias"
                value={watch('categories_id')}
                select
                fullWidth
                variant="outlined"
                onChange={(e) =>{
                    setValue('categories_id', e.target.value)
                }}
                margin="normal"
                SelectProps={{
                    multiple: true
                }}
            >
                <MenuItem value='' disabled >
                    <em>Selecione Categorias</em>
                </MenuItem>
                {categories.map((category, key) =>(
                    <MenuItem value={category.id} key={key}>
                        {category.name}
                    </MenuItem>
                ))}

            </TextField>

            <Box dir="rtl">
                <Button  {...buttonProps} onClick={() => onSubmit(getValues())}>Salvar</Button>
                <Button  {...buttonProps} type="submit">Salvar e continuar</Button>

            </Box>
        </form>
    );
};