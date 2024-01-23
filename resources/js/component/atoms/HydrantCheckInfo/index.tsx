import React from 'react';
import { Col, Row } from 'react-bootstrap';
import Globalvars from '../../../globalvars';
import { HydrantCheckInfoProps } from '../../../props/props';
import { getDateGerman, getDateWeekName, getHourMinutes } from '../../helper';
import GridSimple from '../../molecules/GridSimple';
import ErrorBoundary from '../../organisms/errorboundary';
import PictureSourcSet from '../Picture/SourceSet';
import H2 from '../Typography/H2';

const HydrantCheckInfo: React.FC<React.PropsWithChildren<HydrantCheckInfoProps>> = (
  props: HydrantCheckInfoProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  console.log(props.data);
  if (typeof props.data.hydrantcheck === 'undefined') {
    return <></>;
  }

  const data = props.data.hydrantcheck;

  const datenow = new Date();
  const date = new Date(data.date);
  if (datenow.getTime() <= date.getTime()) {
    return (
      <ErrorBoundary>
        <GridSimple>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <H2 className="text-center" label="Bürgerinfo: Hydrantendienst" />
            </Col>
          </Row>
          <Row>
            <Col xxl={8} xl={8} lg={8} md={8} sm={8} xs={8}>
              <p className="text-center">
                Die Freiwillige Feuerwehr Sankt Michaelisdonn möchte alle Einwohnerinnen und Einwohner
                informieren, dass am {getDateWeekName(data.date)},{' '}
                {getDateGerman(data.date, 'long')}, ab {getHourMinutes(data.time)} Uhr die Hydranten
                im Wassernetz von Sankt Michaelisdonn und Ramhusen überprüft werden. Es wird vorsorglich
                darauf hingewiesen, dass gegebenenfalls mit Druckschwankungen und Eintrübungen im
                Wassernetz zurechnen ist! Während dieser Maßnahme kann zeitweise braunes Wasser aus
                den Leitungen fließen. Dieses Wasser ist gesundheitlich unbedenklich. Es sollte
                jedoch auf den Gebrauch verzichtet werden. Das braune Wasser aus dem Wasserhahn ist
                für einige Minuten über möglichst viele Hähne ablaufen zu lassen, bis das Wasser
                wieder vollkommen klar ist.
              </p>
              <p className="text-center">
                Bitte denken Sie daran, die Hydranten-Deckel sind freizuhalten.
              </p>
            </Col>
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={4}>
              <PictureSourcSet
                className="picture"
                img="hydranten_1.jpg"
                path={Globalvars.getFilePath() + '/hydrant/'}
              />
            </Col>
          </Row>
        </GridSimple>
      </ErrorBoundary>
    );
  }
  return <></>;
};
export default HydrantCheckInfo;
