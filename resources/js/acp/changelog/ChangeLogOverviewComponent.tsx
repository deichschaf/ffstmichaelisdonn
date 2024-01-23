import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import ButtonAddLine from '../../component/molecules/ButtonAddLine';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SortTable from '../../component/molecules/SortTable';
import ErrorBoundary from '../../component/organisms/errorboundary';
import { ChangeLogProps } from '../../props/props';
import { checkContentTitle, deleteLink, editLink } from '../helper';

function getList(array) {
  const list = [...array];
  const generatelist = list.map((item, idx) => <li key={idx}>{item}</li>);
  return <ul className="changelogList">{generatelist}</ul>;
}

function returnChangeLogList(props: any, headline) {
  if (typeof props.changelog === 'undefined') {
    return <></>;
  }
  const changelog = [...props.changelog];
  const ths = ['Datum', 'Release', 'Tasks', 'Editieren'];
  const datas = [] as any;
  changelog.map((item, idx) =>
    datas.push([
      { content: checkContentTitle(item.date), className: '' },
      { content: checkContentTitle(item.title), className: '' },
      { content: getList(item.description), className: '' },
      { content: editLink(props, item), className: '' },
    ] as any),
  );

  return (
    <SortTable
      headline={headline}
      table_id="adminOverviewContent"
      datas={datas}
      ths={ths}
      showPaginationList={false}
      showSearchBox={false}
    />
  );
}

const ChangeLogOverviewComponent: React.FC<React.PropsWithChildren<ChangeLogProps>> = (
  props: ChangeLogProps,
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);
  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/changelog/overview');
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
            <PageHeadline label="Admin - ChangeLog List" />
          </Col>
        </Row>
      </div>
      <ButtonAddLine url="/admin/changelog/add" />
      <ErrorBoundary>{returnChangeLogList(appState, 'Admin - ChangeLog List')}</ErrorBoundary>
      <ButtonAddLine url="/admin/changelog/add" />
    </div>
  );
};
export default ChangeLogOverviewComponent;
