import React from 'react';
import { Col, Row } from 'react-bootstrap';
import Globalvars from '../../../../globalvars';
import { LayoutMainContentProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';
import WidgetRight from '../../../organisms/Widget/Right';
import WidgetTop from '../../../organisms/Widget/Top';
import AsideContact from './module/AsideContact';
import WidgetBottomArea from './module/WidgetBottomArea';
import WidgetCenterArea from './module/WidgetCenterArea';

const LayoutMainContent: React.FC<React.PropsWithChildren<LayoutMainContentProps>> = (
  props: LayoutMainContentProps
): JSX.Element => {
  if (typeof props.children === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      {Globalvars.getIsFiredepartment() ? (
        <>
          <WidgetCenterArea widget={props.widget} pagedata={props.pagedata} />
          <Row>
            <Col xxl={9} xl={9} lg={9} md={12} sm={12} xs={12} className="page">
              <WidgetTop widget={props.widget} pagedata={props.pagedata} />
              {props.children}
            </Col>
            <Col xxl={3} xl={3} lg={3} md={12} sm={12} xs={12} className="sidebar">
              <WidgetRight widget={props.widget} pagedata={props.pagedata} />
            </Col>
          </Row>
          <WidgetBottomArea widget={props.widget} pagedata={props.pagedata} />
        </>
      ) : (
        <>
          <section className="page col-sm-9">{props.children}</section>
          <aside className="sidebar col-sm-3">
            <>
              <AsideContact pagedata={props.pagedata} />
            </>
          </aside>
        </>
      )}
    </ErrorBoundary>
  );
};
export default LayoutMainContent;
