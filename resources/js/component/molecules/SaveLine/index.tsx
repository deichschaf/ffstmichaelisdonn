import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { SaveLineProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import GridSimple from '../GridSimple';
import { Link } from 'react-router-dom';

const SaveLine: React.FC<React.PropsWithChildren<SaveLineProps>> = (
  props: SaveLineProps
): JSX.Element => (
  <ErrorBoundary>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} />
    </Row>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <GridSimple>
          <Row>
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={4}>
              <div className="form-group">
                <div className="controls">
                  <button onClick={props.SubmitForm} className="btn btn-primary">
                    Submit
                  </button>
                </div>
              </div>
            </Col>
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={4} />
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={4}>
              <div className="form-group">
                <div className="controls">
                  {props.backurl !== '' ? (
                    <Link to={props.backurl} className="btn btn-primary">
                      zurück zur Übersicht
                    </Link>
                  ) : (
                    <></>
                  )}
                </div>
              </div>
            </Col>
          </Row>
        </GridSimple>
      </Col>
    </Row>
  </ErrorBoundary>
);
export default SaveLine;
