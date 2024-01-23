import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import ButtonAddLine from '../../component/molecules/ButtonAddLine';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SortTable from '../../component/molecules/SortTable';
import ErrorBoundary from '../../component/organisms/errorboundary';
import { LinksOverviewComponentProps } from '../../props/props';
import { checkContentTitle, deleteLink, editLink, showImgActive } from '../helper';
import Globalvars from '../../globalvars';

const LinksOverviewComponent: React.FC<React.PropsWithChildren<LinksOverviewComponentProps>> = (
  props: LinksOverviewComponentProps
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);

  function returnlinksList(props: any, headline) {
    if (typeof props.links === 'undefined') {
      return <></>;
    }
    const links = [...props.links];
    const ths = ['Titel', 'Kategorie', 'erreichbar', 'Löschen', 'Editieren'];
    const datas = [] as any;
    links.map((item, idx) =>
      datas.push([
        { content: checkContentTitle(item.title), className: '' },
        { content: checkContentTitle(item.category), className: '' },
        { content: showImgActive(item, Globalvars.JSDomain()), className: '' },
        { content: deleteLink(props, item), className: '' },
        { content: editLink(props, item), className: '' },
      ] as any)
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

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/links/overview');
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
            <PageHeadline label="Admin - Links List" />
          </Col>
        </Row>
      </div>
      <ButtonAddLine url="/admin/links/add" />
      <ErrorBoundary>{returnlinksList(appState, 'Admin - Links List')}</ErrorBoundary>
      <ButtonAddLine url="/admin/links/add" />
    </div>
  );
};
export default LinksOverviewComponent;
