// @flow
import * as React from 'react';
import MUIDataTable, {MUIDataTableColumn, MUIDataTableOptions} from "mui-datatables";
import {useEffect, useState} from "react";
import {httpVideo} from "../../util/http";
import {Chip} from "@material-ui/core";
import format from 'date-fns/format'
import parseISO from 'date-fns/parseISO'
import categoryHttp from "../../util/http/category-http";

const columnsDefinition: MUIDataTableColumn[] = [
    {
        name: "name",
        label: "Nome"
    },
    {
        name:"is_acyive",
        label: "Ativo?",
        options:{
            customBodyRender(value, tableMeta, updateValue) {
                return value ? <Chip label="Sim" color="primary"/> : <Chip label="Não" color="secondary" />
            }
        }
    },
    {
        name: "created_at",
        label: "Criado em",
        options:{
            customBodyRender(value, tableMeta, updateValue) {
                return <span>{format(parseISO(value), 'dd/MM/yyyy H:m')}</span>
            }
        }

    }
]

const options:MUIDataTableOptions = {
    textLabels: {
        pagination: {
            rowsPerPage: "Itens por página"
        }
    }
}

type Props = {
    
};
interface Category {
    id: string,
    name: string
}

const Table = (props: Props) => {
    const [data, setData] = useState([])

    useEffect(()=>{
        categoryHttp.list().then((response)=>setData(response.data))
    },[])
    return (
        <MUIDataTable columns={columnsDefinition}
                      title="Listagem de Categorias"
                      data={data}
                      options={options}
        >
        </MUIDataTable>
    );
};

export default Table