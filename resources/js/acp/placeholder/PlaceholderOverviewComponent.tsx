import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import ButtonAddLine from '../../component/molecules/ButtonAddLine';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SortTable from '../../component/molecules/SortTable';
import ErrorBoundary from '../../component/organisms/errorboundary';
import { PlaceholderOverviewComponentProps } from '../../props/props';
import { checkContentTitle, editLink } from '../helper';

function getList(array) {
  const list = [...array];
  const generatelist = list.map((item, idx) => <li key={idx}>{item}</li>);
  return <ul className="placeholderList">{generatelist}</ul>;
}

function returnplaceholderList(props: any, headline) {
  if (typeof props.placeholder === 'undefined') {
    return <></>;
  }
  const placeholder = [...props.placeholder];
  const ths = ['Placeholder', 'Text', 'Editieren'];
  const datas = [] as any;
  placeholder.map((item, idx) =>
    datas.push([
      { content: checkContentTitle(item.placeholder_name), className: '' },
      { content: checkContentTitle(item.placeholder_text), className: '' },
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

const PlaceholderOverviewComponent: React.FC<
  React.PropsWithChildren<PlaceholderOverviewComponentProps>
> = (props: PlaceholderOverviewComponentProps): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);
  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/placeholder/overview');
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
            <PageHeadline label="Admin - Placeholder List" />
          </Col>
        </Row>
      </div>
      <ButtonAddLine url="/admin/placeholder/add" />
      <ErrorBoundary>{returnplaceholderList(appState, 'Admin - Placeholder List')}</ErrorBoundary>
      <ButtonAddLine url="/admin/placeholder/add" />
    </div>
  );
};
export default PlaceholderOverviewComponent;
