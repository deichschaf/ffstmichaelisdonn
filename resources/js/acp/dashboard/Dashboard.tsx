import React, { useEffect, useRef, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import Loading from '../../component/atoms/Loading/Loading';
import PageHeadline from '../../component/atoms/PageHeadline';
import AdminStatistic from '../../component/molecules/AdminStatistic';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import ErrorBoundary from '../../component/organisms/errorboundary';
import NotificationMessages from '../../component/organisms/NotificationMessages/NotificationMessages';
import { DashboardProps } from '../../props/props';

function returnDashboard(props) {
  if (typeof props === 'undefined') {
    return <></>;
  }
  return (
    <>
      <Row>
        <Col xxl={3} xl={3} lg={3} md={3} sm={6} xs={12}>
          <ErrorBoundary>
            <AdminStatistic statistic={props.todos} color="green" />
          </ErrorBoundary>
        </Col>
        <Col xxl={3} xl={3} lg={3} md={3} sm={6} xs={12}>
          <ErrorBoundary>
            <AdminStatistic statistic={props.todos} color="blue" />
          </ErrorBoundary>
        </Col>
      </Row>
      <Row>
        <Col xxl={3} xl={3} lg={3} md={3} sm={6} xs={12}>
          <ErrorBoundary>
            <NotificationMessages messages={props.changelog} headline="ChangeLog" color="white" />
          </ErrorBoundary>
        </Col>
        <Col xxl={3} xl={3} lg={3} md={3} sm={6} xs={12}>
          <ErrorBoundary>
            <NotificationMessages messages={props.todos_list} headline="ToDo" color="white" />
          </ErrorBoundary>
        </Col>
      </Row>
    </>
  );
}

const Dashboard: React.FC<React.PropsWithChildren<DashboardProps>> = (
  props: DashboardProps,
): JSX.Element => {
  const [loading, setLoading] = useState(false);
  const [appState, setAppState] = useState<any>(null);

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/dashboard');
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
            <PageHeadline label="Admin - Dashboard" />
          </Col>
        </Row>
      </div>
      <ErrorBoundary>{returnDashboard(appState)}</ErrorBoundary>
    </div>
  );
};
export default Dashboard;
