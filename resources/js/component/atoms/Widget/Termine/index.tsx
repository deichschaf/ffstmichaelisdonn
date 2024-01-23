import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { WidgetTermineProps } from '../../../../props/props';
import Spacer from '../../../molecules/Spacer';
import ErrorBoundary from '../../../organisms/errorboundary';
import ContentRow from '../../../organisms/PageContent/components/ContentRow';
import ContentSeperator from '../../../organisms/PageContent/components/ContentSeperator';
import FAR from '../../Icon/FAR';
import SVGIcon from '../../SVGIcon';

const WidgetTermine: React.FC<React.PropsWithChildren<WidgetTermineProps>> = (
  props: WidgetTermineProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const { termine } = props.data;
  const lenght = termine.length;
  return (
    <ErrorBoundary>
      {lenght === 0 ? (
        <ContentRow>keine Termine vorhanden</ContentRow>
      ) : (
        <>
          {termine.map((item, idx) => (
            <div key={idx} className="colorchanger">
              <ContentRow>
                <Row>
                  <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
                    <FAR className="calendar-days" />
                  </Col>
                  <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
                    {item.date_start}
                  </Col>
                </Row>
                <Row>
                  <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
                    <FAR className="clock" />
                  </Col>
                  <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
                    {item.time_start} Uhr
                  </Col>
                </Row>
                <Row>
                  <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
                    <FAR className="file" />
                  </Col>
                  <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
                    {item.title}
                  </Col>
                </Row>
                {item.description !== '' ? (
                  <Row>
                    <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2} />
                    <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
                      {item.description}
                    </Col>
                  </Row>
                ) : (
                  <></>
                )}
              </ContentRow>
              {lenght > 1 && idx < lenght - 1 ? (
                <>
                  <Spacer />
                  <ContentSeperator />
                  <Spacer />
                </>
              ) : (
                <></>
              )}
            </div>
          ))}
        </>
      )}
    </ErrorBoundary>
  );
};
export default WidgetTermine;
