// @flow
import {Box, Fab} from '@material-ui/core';
import * as React from 'react';
import {Page} from "../../components/Page";
import {Link} from "react-router-dom";
import AddIcon from '@material-ui/icons/Add';
import Table from "./Table";

interface CategoriesProps {

};
const Categories = (props: CategoriesProps) => {
    return (
        <Page title={'Listagem Categorias'}>
            <Box dir={'rtl'}>
                <Fab title="Adicionar Categoria"
                    size="small"
                     component={Link}
                     to="categories/create"
                     color="primary"
                >
                    <AddIcon/>
                </Fab>
            </Box>
            <Box>
                <Table/>
            </Box>
        </Page>
    );
};

export default Categories