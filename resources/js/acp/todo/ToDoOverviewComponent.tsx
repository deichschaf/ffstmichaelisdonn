import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import ButtonAddLine from '../../component/molecules/ButtonAddLine';
import ButtonLine from '../../component/molecules/ButtonLine';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SortTable from '../../component/molecules/SortTable';
import { ToDoProps } from '../../props/props';
import { checkStatusId, checkToDoArea, editLink, getContent, getTodoType } from '../helper';

function returnToDoList(props: any, status, headline, idx) {
  if (typeof props.todos === 'undefined') {
    return <></>;
  }
  const todos = [...props.todos];
  const ths = ['Bereich', 'Beschreibung', 'Typ', 'Editieren'];
  const datas = [] as any;
  const table_id = `adminOverviewToDos${status.id}`;
  todos.map((item, idx) =>
    checkStatusId(status.id, item.status_id)
      ? datas.push([
          { content: checkToDoArea(item.area_id, props.todo_area), className: '' },
          { content: getContent(item.title, item.description), className: '' },
          { content: getTodoType(item.type_id, props), className: '' },
          { content: editLink(props, item), className: '' },
        ] as any)
      : '',
  );

  return (
    <div key={idx}>
      <SortTable
        headline={headline + status.readable}
        table_id={table_id}
        datas={datas}
        ths={ths}
        showPaginationList={false}
        showSearchBox={false}
      />
    </div>
  );
}

const ToDoOverviewComponent: React.FC<React.PropsWithChildren<ToDoProps>> = (
  props: ToDoProps,
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/todo/overview');
      response = await response.json();
      setAppState(response);
      setLoading(false);
    }

    fetchMyApi();
  }, []);

  if (loading || appState === null) {
    return <LoadingAlertBox />;
  }
  return (
    <div className="container">
      <div className="overview_headline">
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <PageHeadline label="Admin - ToDo List" />
          </Col>
        </Row>
      </div>
      <Row>
        <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6}>
          <ButtonAddLine url="/admin/todo/add" />
        </Col>
        <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6}>
          <ButtonLine url="/admin/todo/area/overview" icon="folder" title="Bereiche" />
        </Col>
      </Row>
      {typeof appState.todo_status !== 'undefined'
        ? appState.todo_status.map((item, idx) =>
            returnToDoList(appState, item, 'Admin - ToDo List - ', idx),
          )
        : ''}
      <ButtonAddLine url="/admin/todo/add" />
    </div>
  );
};
export default ToDoOverviewComponent;
