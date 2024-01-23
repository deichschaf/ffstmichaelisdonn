import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { useParams } from 'react-router';
import Input from '../../component/atoms/Form/Input/Input';
import PageHeadline from '../../component/atoms/PageHeadline';
import { getCookie, getCSRFToken } from '../../component/component_helper';
import GridSimple from '../../component/molecules/GridSimple';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SaveInfoError from '../../component/molecules/SaveInfoError';
import SaveLine from '../../component/molecules/SaveLine';
import ErrorBoundary from '../../component/organisms/errorboundary';
import { PageAddEditHeadlineComponentProps } from '../../props/props';

const PageAddEditHeadlineComponent: React.FC<
  React.PropsWithChildren<PageAddEditHeadlineComponentProps>
> = (props: PageAddEditHeadlineComponentProps): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [errorText, setErrorText] = useState<any>(null);
  const [responseText, setResponseText] = useState<any>(null);
  const [getTitle, setTitle] = useState<string>('');
  const [getNaviTitle, setNaviTitle] = useState<string>('');
  const [getEditType, setEditType] = useState<string>('hinzufügen');
  const [getId, setId] = useState<number>(0);
  const { id } = useParams();

  function setDefault(data) {
    setId(data.id);
  }

  function CheckResponse(data) {
    if (data.success === true) {
      setResponseText('Erfolgreich gespeichert!');
    } else {
      setErrorText(data.errorMessage);
    }
  }

  function setCatchError(err) {
    setErrorText(err);
  }

  const SubmitForm = event => {
    event.preventDefault();
    setErrorText(null);
    setResponseText(null);
    const token = getCSRFToken();
    // console.log(token);
    const csrfToken = getCookie('XSRF-TOKEN');
    let headers = new Headers({
      'Content-Type': 'application/json',
    });
    if (csrfToken !== null) {
      headers = new Headers({
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      });
    }
    fetch('/api/admin/page/save', {
      method: 'POST',
      headers,
      body: JSON.stringify({
        id: getId,
        title: getTitle,
        navititle: getNaviTitle,
        'csrf-token': token,
        _token: token,
      }),
    })
      .then(response => response.json())
      .then(data => CheckResponse(data))
      .catch(err => setCatchError(err));
  };

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch(`/api/admin/page/data/${id}`);
      response = await response.json();
      setDefault(response);
      setLoading(false);
    }

    if (id !== undefined) {
      setEditType('bearbeiten');
      fetchMyApi();
    } else {
      setLoading(false);
    }
  }, [id]);

  if (loading) {
    return <LoadingAlertBox />;
  }

  return (
    <div className="container">
      <div className="overview_headline">
        <ErrorBoundary>
          <SaveInfoError responseText={responseText} errorText={errorText} />
        </ErrorBoundary>
        <ErrorBoundary>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <PageHeadline label={`Admin - Seitentitel ${getEditType}`} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Titel:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getTitle}
                        name="title"
                        placeholder=""
                        className="form-control"
                        onChange={e => setTitle(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Navigationstitel:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getNaviTitle}
                        name="navititle"
                        placeholder=""
                        className="form-control"
                        onChange={e => setNaviTitle(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <SaveLine SubmitForm={SubmitForm} backurl="/page/overview" />
        </ErrorBoundary>
      </div>
    </div>
  );
};
export default PageAddEditHeadlineComponent;
